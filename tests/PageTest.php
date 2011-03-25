<?php
namespace aura\web;
use aura\signal\Manager as SignalManager;
use aura\signal\HandlerFactory;
use aura\signal\ResultFactory;
use aura\signal\ResultCollection;

/**
 * Test class for Page.
 * Generated by PHPUnit on 2011-03-19 at 15:00:21.
 */
class PageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Page
     */
    protected $page;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        parent::setUp();
    }
    
    protected function newPage($params = null)
    {
        return new MockPage(
            new Context($GLOBALS),
            new SignalManager(new HandlerFactory, new ResultFactory, new ResultCollection),
            new Transfer,
            $params
        );
    }
    
    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @todo Implement testExec().
     */
    public function testExecAndHooks()
    {
        $page = $this->newPage(array('action' => 'index'));
        $transfer = $page->exec();
        $this->assertTrue($page->_pre_exec);
        $this->assertTrue($page->_pre_action);
        $this->assertTrue($page->_post_action);
        $this->assertTrue($page->_post_exec);
        $this->assertType('aura\web\Transfer', $transfer);
        $this->assertSame('actionIndex', $transfer->data['action_method']);
    }

    /**
     * @expectedException \aura\web\Exception_NoMethodForAction
     */
    public function testExecNoMethodForAction()
    {
        $page = $this->newPage(array('action' => 'noSuchAction'));
        $transfer = $page->exec();
    }

    /**
     * @todo Implement testSkipAction().
     */
    public function testSkipAction()
    {
        $page = $this->newPage(array('action' => 'index'));
        $page->skipAction();
        $transfer = $page->exec();
        $this->assertTrue($page->_pre_exec);
        $this->assertTrue($page->_pre_action);
        $this->assertFalse($page->_post_action);
        $this->assertTrue($page->_post_exec);
        $this->assertType('aura\web\Transfer', $transfer);
        $this->assertFalse(isset($transfer->data['action_method']));
    }
}