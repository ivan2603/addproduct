<?php
namespace Module\ProductLabel\Plugin\Magento\ConfigurableProduct\Block\Product\View\Type;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable as SubjectConfigurable;
use Magento\Framework\Json\DecoderInterface;
use Magento\Framework\Json\EncoderInterface;

class Configurable
{
    protected $jsonEncoder;
    protected $jsonDecoder;
    protected $productRepository;

    public function __construct(
        EncoderInterface $jsonEncoder,
        DecoderInterface $jsonDecoder,
        ProductRepositoryInterface $productRepository
    ) {
        $this->jsonDecoder = $jsonDecoder;
        $this->jsonEncoder = $jsonEncoder;
        $this->productRepository = $productRepository;
    }

    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }

    public function afterGetJsonConfig(
        SubjectConfigurable $subject,
        $result
    ) {
        $config = $result;
        $config = $this->jsonDecoder->decode($config);
        $config['custom_attribute'] = [];

        foreach ($subject->getAllowProducts() as $simpleProduct) {
            if (!empty($simpleProduct->getData('badge_label'))) {
                $config['custom_attribute'][$simpleProduct->getId()] = explode(',', $simpleProduct->getData('badge_label'));
            }
        }

        return $this->jsonEncoder->encode($config);
    }
}
