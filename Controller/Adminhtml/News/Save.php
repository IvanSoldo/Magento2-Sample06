<?php

namespace Inchoo\Sample06\Controller\Adminhtml\News;

use Inchoo\Sample03\Api\Data\NewsInterfaceFactory;
use Inchoo\Sample03\Api\NewsRepositoryInterface;
use Magento\Backend\App\Action;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var NewsRepositoryInterface
     */
    private $newsRepository;
    /**
     * @var NewsInterfaceFactory
     */
    private $newsFactory;

    /**
     * Save News.
     *
     * @param Action\Context $context
     * @param NewsRepositoryInterface $newsRepository
     * @param NewsInterfaceFactory $newsFactory
     */

    public function __construct(Action\Context $context, NewsRepositoryInterface $newsRepository, NewsInterfaceFactory $newsFactory)
    {
        parent::__construct($context);
        $this->newsRepository = $newsRepository;
        $this->newsFactory = $newsFactory;
    }


    public function execute()
    {

        $id = $this->getRequest()->getParam('news_id');

        if (!$id) {
            $news = $this->newsFactory->create();
            $this->saveNews($news);
            $this->messageManager->addSuccessMessage('News added!');
        }else {
            $news = $this->newsRepository->getById($id);
            $this->saveNews($news);
            $this->messageManager->addSuccessMessage('News edited!');
        }

        return $this->_redirect('sample06/news/index');
    }

    private function saveNews($news) {
        $news
            ->setTitle($this->getRequest()->getParam('title'))
            ->setContent($this->getRequest()->getParam('content'));
        $this->newsRepository->save($news);
    }
}
