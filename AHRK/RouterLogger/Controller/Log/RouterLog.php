<?php
declare(strict_types=1);

namespace AHRK\RouterLogger\Controller\Log;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RouterList;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;
use Psr\Log\LoggerInterface;


/**
 * class to log routers list for every request
 */
class RouterLog implements \Magento\Framework\App\ActionInterface {

    private RouterList $routerList;

    private LoggerInterface $logger;

    private PageFactory $pageFactory;

    /**
     * @param RouterList $routerList
     * @param LoggerInterface $logger
     * @param PageFactory $pageFactory
     */
    public function __construct(
        RouterList $routerList,
        LoggerInterface $logger,
        PageFactory $pageFactory
    ) {
        $this->routerList = $routerList;
        $this->logger = $logger;
        $this->pageFactory = $pageFactory;
    }


    /**
     * @return Page|ResultInterface
     */
    public function execute()
    {
        $routers= $this->saveRouterLogs();
        $this->logger->info($routers);
        return $this->pageFactory->create();
    }

    private function saveRouterLogs(): string
    {
        $routers = '';
        foreach ($this->routerList as $router) {
            $routers .= get_class($router)."\n";
        }
        return $routers;
    }
}
