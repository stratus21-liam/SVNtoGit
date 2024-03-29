<?php
/**
 * @category    WeltPixel
 * @package     WeltPixel_LayeredNavigation
 * @copyright   Copyright (c) 2018 Weltpixel
 * @author      Weltpixel TEAM
 */

namespace WeltPixel\LayeredNavigation\Helper;

use Magento\Store\Model\ScopeInterface;
use \Magento\CatalogSearch\Model\ResourceModel\EngineInterface;

/**
 * Class Data
 * @package WeltPixel\LayeredNavigation\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const FILTER_TYPE_SLIDER = 'slider';
    const FILTER_TYPE_LIST = 'list';
    const SLIDE_IN_STYLE = 1;
    const FILTER_BUTTON_LABEL = 'Filter';

    protected $_currentEngine = '';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var int
     */
    protected $_storeId;

    /**
     * @var Config
     */
    private $pageConfig;


    /**
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\View\Page\Config $pageConfig
    )
    {
        $this->_storeManager = $storeManager;
        $this->pageConfig = $pageConfig;
        parent::__construct($context);

        $this->_storeId = $this->getCurrentStoreId();
    }

    /**
     * Return current store_id
     *
     * @return int
     */
    public function getCurrentStoreId()
    {
        return $this->_storeManager->getStore()->getId();
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->getValue('weltpixel_layerednavigation/general/enable', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function isAjaxEnabled($storeId = null)
    {
        return $this->scopeConfig->getValue('weltpixel_layerednavigation/general/ajax', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function showCategoriesBlock($storeId = null)
    {
        return $this->scopeConfig->getValue('weltpixel_layerednavigation/sidebar/category_block', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function showCompareBlock($storeId = null)
    {
        return $this->scopeConfig->getValue('weltpixel_layerednavigation/sidebar/compare_block', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function showWishlistBlock($storeId = null)
    {
        return $this->scopeConfig->getValue('weltpixel_layerednavigation/sidebar/wishlist_block', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function showRecentlyOrderedBlock($storeId = null)
    {
        return $this->scopeConfig->getValue('weltpixel_layerednavigation/sidebar/recentlyordered_block', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param null $storeId
     * @return mixed
     */
    public function getFilterButton($storeId = null)
    {
        return $this->scopeConfig->getValue('weltpixel_layerednavigation/sidebar/filter_button', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Filter Button option
     *  0-icon only
     *  1-icon & label
     *  2-label only
     *
     * @return \Magento\Framework\Phrase|string
     */
    public function getFilterButtonStyle()
    {
        switch ($this->getFilterButton()) {
            case 0:
                $filterButtonHtml = "<b class='wp-slide-in'></b>";
                break;
            case 1:
                $filterButtonHtml = "<b class='wp-slide-in'></b><b class='wp-filters-text'>" . /* @escapeNotVerified */
                    __(self::FILTER_BUTTON_LABEL) . "</b>";
                break;
            case 2:
                $filterButtonHtml = __(self::FILTER_BUTTON_LABEL);
                break;
            default:
                $filterButtonHtml = '';
        }

        return $filterButtonHtml;
    }

    /**
     * Check the engine provider is 'elasticsearch'
     * @deprecated
     *
     * @return bool
     */
    public function isElasticSearchEngine()
    {
        if (!$this->_currentEngine) {
            $this->_currentEngine = $this->scopeConfig->getValue(EngineInterface::CONFIG_ENGINE_PATH, ScopeInterface::SCOPE_STORE);
        }
        if($this->_currentEngine == 'elasticsearch' || $this->_currentEngine == 'elasticsearch5'
            || $this->_currentEngine == 'elasticsearch6'  || $this->_currentEngine == 'elasticsearch7' ) {
            return true;
        }

        return false;
    }

    /**
     * Check the engine provider is 'elasticsearch' or 'opensearch'
     * @deprecated
     *
     * @return bool
     */
    public function isElasticOrOpenSearchEngine()
    {
        if (!$this->_currentEngine) {
            $this->_currentEngine = $this->scopeConfig->getValue(EngineInterface::CONFIG_ENGINE_PATH, ScopeInterface::SCOPE_STORE);
        }
        if($this->_currentEngine == 'elasticsearch' || $this->_currentEngine == 'elasticsearch5'
            || $this->_currentEngine == 'elasticsearch6'  || $this->_currentEngine == 'elasticsearch7' || $this->_currentEngine == 'opensearch' ) {
            return true;
        }

        return false;
    }

}
