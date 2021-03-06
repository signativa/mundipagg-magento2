<?php
namespace MundiPagg\MundiPagg\Model;

use \Magento\Store\Model\ScopeInterface;

/**
 * Class MundiPaggConfigProvider
 *
 * @package MundiPagg\MundiPagg\Model
 */
class MundiPaggConfigProvider
{
    /**
     * Contains if the module is active or not
     */
    const XML_PATH_SOFTDESCRIPTION  = 'payment/mundipagg_creditcard/soft_description';
    const XML_PATH_ACTIVE            = 'mundipagg_mundipagg/global/active';
    const PATH_CUSTOMER_STREET      = 'payment/mundipagg_customer_address/street_attribute';
    const PATH_CUSTOMER_NUMBER      = 'payment/mundipagg_customer_address/number_attribute';
    const PATH_CUSTOMER_COMPLEMENT  = 'payment/mundipagg_customer_address/complement_attribute';
    const PATH_CUSTOMER_DISTRICT    = 'payment/mundipagg_customer_address/district_attribute';


    /**
     * Contains scope config of Magento
     *
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Contains the configurations
     *
     * @var \Magento\Framework\App\Config\ConfigResource\ConfigInterface
     */
    protected $config;

    /**
     * ConfigProvider constructor.
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\Config\ConfigResource\ConfigInterface $config
    )
    {
        $this->scopeConfig = $scopeConfig;
        $this->config = $config;
    }

    /**
     * Returns the soft_description configuration
     *
     * @return string
     */
    public function getSoftDescription()
    {
        return $this->scopeConfig->getValue(self::XML_PATH_SOFTDESCRIPTION, ScopeInterface::SCOPE_STORE);
    }

    public function validateSoftDescription()
    {
        $softDescription = $this->getSoftDescription();

        if(strlen($softDescription) > 22){
            $newResult = substr($softDescription, 0, 21);
            $this->config->saveConfig(self::XML_PATH_SOFTDESCRIPTION, $newResult, 'default', 0);

            return false;
        }

        return true;
    }
    /**
     * Returns the soft_description configuration
     *
     * @return string
     */
    public function getModuleStatus()
    {
        return
            $this->scopeConfig->getValue(
                self::XML_PATH_ACTIVE,
                ScopeInterface::SCOPE_STORE
            );
    }

    public function getCustomerAddressConfiguration()
    {
        $street = $this->scopeConfig->getValue(
            self::PATH_CUSTOMER_STREET,
            ScopeInterface::SCOPE_STORE
        );

        $number = $this->scopeConfig->getValue(
            self::PATH_CUSTOMER_NUMBER,
            ScopeInterface::SCOPE_STORE
        );

        $district = $this->scopeConfig->getValue(
            self::PATH_CUSTOMER_DISTRICT,
            ScopeInterface::SCOPE_STORE
        );

        return [
            'street' => $street,
            'number' => $number,
            'district' => $district
        ];
    }

}