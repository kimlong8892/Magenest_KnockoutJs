<?php


namespace Magenest\KnockoutJs\Controller\Test;


use Magento\Catalog\Helper\Image;
use Magento\Catalog\Model\ProductFactory;
use Magento\Framework\App\Action\Context;
use Magento\TestFramework\Store\StoreManager;

class Product extends \Magento\Framework\App\Action\Action
{
    protected $productFactoty;
    protected $_storeManager;

    public function __construct(
        Context $context,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager

    )
    {
        $this->productFactoty = $productFactory;
        $this -> _storeManager = $storeManager;
        parent::__construct($context);
    }

    public function execute()
    {
        if($id = $this->getRequest()->getParam('id'))
        {
            $product = $this->productFactoty->create()->load($id);
            if($product->getId() == null)
                return false;

            $productData = [
                'entity_id' => $product->getId(),
                'name' => $product->getName(),
                'price' => "$".$product->getPrice(),
                'src' => $this->_storeManager->getStore()->getBaseUrl().'pub/media/catalog/product'.$product->getImage()
            ];
            echo json_encode($productData);
            return;
        }
    }

    public function getCollection()
    {
        return $this->productFactoty->create()
            ->getCollection()
            ->addAttributeToSelect("*")
            ->setPageSize(5)
            ->setCurPage(1);
    }
}