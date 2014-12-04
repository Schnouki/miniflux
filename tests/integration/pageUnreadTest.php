<?php

require_once 'minifluxTestCase.php';

class pageUnreadTest extends minifluxTestCase
{
    const DEFAULT_COUNTER_PAGE = 6;
    const DEFAULT_COUNTER_UNREAD = 6;
    
    public function setUpPage()
    {
        $url = $this->getURLPageUnread();
        parent::setUpPage($url);
        
        $this->expectedPageUrl = $url;
    }

    // TODO: Miniflux Title could be localized
    public function getExpectedPageTitle()
    {
        return "Miniflux ($this->expectedCounterPage)";
    }

    public function testItemsFromAllFeeds()
    {
        $articles = $this->getArticlesNotFromFeedOne();
        $this->assertNotEmpty($articles, 'no articles from other feeds found');
        
        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD;
        $this->expectedDataSet = $this->getDataSet('fixture_feed1');
    }
    
    public function testOnlyUnreadArticles()
    {
        $articles = $this->getArticlesRead();
        $this->assertEmpty($articles, 'found read articles.');
        
        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD;
        $this->expectedDataSet = $this->getDataSet('fixture_feed1');
    }

    public function testMarkReadNotBookmarkedArticleLink()
    {
        $article = $this->getArticleUnreadNotBookmarked();

        $link = $this->getLinkReadStatusToogle($article);
        $link->click();

        $visible = $this->waitForArticleInvisible($article);
        $this->assertTrue($visible, 'article is is not invisible');

        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE - 1;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD - 1;
        $this->expectedDataSet = $this->getDataSet('expected_MarkReadNotBookmarkedArticle');
    }

    public function testMarkReadNotBookmarkedArticleKeyboard()
    {
        $article = $this->getArticleUnreadNotBookmarked();
        
        $this->setArticleAsCurrentArticle($article);
        $this->keys($this->getShortcutToogleReadStatus());
        
        $visible = $this->waitForArticleInvisible($article);
        $this->assertTrue($visible, 'article is is not invisible');
        
        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE - 1;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD - 1;
        $this->expectedDataSet = $this->getDataSet('expected_MarkReadNotBookmarkedArticle');
    }
    
    public function testMarkReadBookmarkedArticleLink()
    {
        $article = $this->getArticleUnreadBookmarked();

        $link = $this->getLinkReadStatusToogle($article);
        $link->click();

        $visible = $this->waitForArticleInvisible($article);
        $this->assertTrue($visible, 'article is is not invisible');

        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE - 1;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD - 1;
        $this->expectedDataSet = $this->getDataSet('expected_MarkReadBookmarkedArticle');
    }

    public function testMarkReadBookmarkedArticleKeyboard()
    {
        $article = $this->getArticleUnreadBookmarked();
        
        $this->setArticleAsCurrentArticle($article);
        $this->keys($this->getShortcutToogleReadStatus());
        
        $visible = $this->waitForArticleInvisible($article);
        $this->assertTrue($visible, 'article is is not invisible');

        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE - 1;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD - 1;
        $this->expectedDataSet = $this->getDataSet('expected_MarkReadBookmarkedArticle');
    }

    public function testBookmarkUnreadArticleLink()
    {
        $article = $this->getArticleUnreadNotBookmarked();

        $link = $this->getLinkBookmarkStatusToogle($article);
        $link->click();

        $visible = $this->waitForIconBookmarkVisible($article);
        $this->assertTrue($visible, 'bookmark icon is not visible');

        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD;
        $this->expectedDataSet = $this->getDataSet('expected_BookmarkUnreadArticle');
    }

    public function testBookmarkUnreadArticleKeyboard()
    {
        $article = $this->getArticleUnreadNotBookmarked();

        $this->setArticleAsCurrentArticle($article);
        $this->keys($this->getShortcutToogleBookmarkStatus());

        $visible = $this->waitForIconBookmarkVisible($article);
        $this->assertTrue($visible, 'bookmark icon is not visible');
        
        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD;
        $this->expectedDataSet = $this->getDataSet('expected_BookmarkUnreadArticle');
    }

    public function testUnbookmarkUnreadArticleLink()
    {
        $article = $this->getArticleUnreadBookmarked();

        $link = $this->getLinkBookmarkStatusToogle($article);
        $link->click();

        $invisible = $this->waitForIconBookmarkInvisible($article);
        $this->assertTrue($invisible, 'bookmark icon is not invisible');
        
        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD;
        $this->expectedDataSet = $this->getDataSet('expected_UnbookmarkUnreadArticle');
    }

    public function testUnbookmarkUnreadArticleKeyboard()
    {
        $article = $this->getArticleUnreadBookmarked();

        $this->setArticleAsCurrentArticle($article);
        $this->keys($this->getShortcutToogleBookmarkStatus());

        $invisible = $this->waitForIconBookmarkInvisible($article);
        $this->assertTrue($invisible, 'bookmark icon is not invisible');
        
        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD;
        $this->expectedDataSet = $this->getDataSet('expected_UnbookmarkUnreadArticle');
    }

    public function testRemoveUnreadNotBookmarkedArticleLink()
    {
        $article = $this->getArticleUnreadNotBookmarked();

        $link = $this->getLinkRemove($article);
        $link->click();

        $invisible = $this->waitForArticleInvisible($article);
        $this->assertTrue($invisible, 'article is is not invisible');

        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE - 1;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD - 1;
        $this->expectedDataSet = $this->getDataSet('expected_RemoveUnreadNotBookmarkedArticle');
    }

    public function testRemoveUnreadBookmarkedArticleLink()
    {
        $article = $this->getArticleUnreadBookmarked();

        $link = $this->getLinkRemove($article);
        $link->click();

        $invisible = $this->waitForArticleInvisible($article);
        $this->assertTrue($invisible, 'article is is not invisible');

        $this->expectedCounterPage = static::DEFAULT_COUNTER_PAGE - 1;
        $this->expectedCounterUnread = static::DEFAULT_COUNTER_UNREAD - 1;
        $this->expectedDataSet = $this->getDataSet('expected_RemoveUnreadBookmarkedArticle');
    }
    
    public function testMarkAllReadHeaderLink()
    {
        $link = $this->getLinkMarkAllReadHeader();
        $link->click();
        
        $read = $this->waitForArticlesMarkRead();
        $this->assertTrue($read, 'there are still unread articles');
        
        $this->expectedCounterUnread = '';
        $this->expectedPageUrl = PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_BASEURL.'?action=feeds&nothing_to_read=1';
        $this->expectedDataSet = $this->getDataSet('fixture_OnlyReadArticles', FALSE);
        
        $this->ignorePageTitle = TRUE;
    }

    public function testMarkAllReadBottomLink()
    {
        $link = $this->getLinkMarkAllReadBottom();
        $link->click();
        
        $read = $this->waitForArticlesMarkRead();
        $this->assertTrue($read, 'there are still unread articles');
        
        $this->expectedCounterUnread = '';
        $this->expectedPageUrl = PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_BASEURL.'?action=feeds&nothing_to_read=1';
        $this->expectedDataSet = $this->getDataSet('fixture_OnlyReadArticles', FALSE);
        
        $this->ignorePageTitle = TRUE;
    }
    
    public function testRedirectWithZeroArticles()
    {
        $articles = $this->getArticles();
        $this->assertGreaterThanOrEqual(1, count($articles), 'no articles found');
        
        foreach($articles as $article) {
            $link = $this->getLinkReadStatusToogle($article);
            $link->click();
            
            $this->waitForArticleInvisible($article);
        }
        
        $visible = $this->waitForAlert();
        $this->assertTrue($visible, 'alert box did not appear');
        
        $this->expectedCounterUnread = '';
        $this->expectedPageUrl = PHPUNIT_TESTSUITE_EXTENSION_SELENIUM_BASEURL.'?action=feeds&nothing_to_read=1';
        $this->expectedDataSet = $this->getDataSet('fixture_OnlyReadArticles', FALSE);
        
        $this->ignorePageTitle = TRUE;
    }
}
?>