<?php

namespace DHLParcel\Shipping\Plugin\Adminhtml;

use DHLParcel\Shipping\Helper\Data;

abstract class AbstractShipmentsButton
{
    protected $helper;

    public function __construct(Data $helper)
    {
        $this->helper = $helper;
    }

    protected function addButtons(\Magento\Backend\Block\Widget\ContainerInterface $subject, $shipmentId)
    {
        $printServiceEnabled = $this->helper->getConfigData('usability/printing_service/enable');
        $hideDownload = $this->helper->getConfigData('usability/printing_service/hide_download');
        if (!$hideDownload || !$printServiceEnabled) {
            $url = $subject->getUrl('dhlparcel_shipping/shipment/download', ['shipment_id' => $shipmentId]);
            $subject->addButton(
                'dhlparcel_shipping_download',
                [
                    'label'   => __('Download DHL Labels'),
                    'class'   => 'dhlparcel_shipping_print',
                    'onclick' => 'window.open(\'' . $url . '\')'
                ],
                101
            );
        }

        $enablePrint = $this->helper->getConfigData('usability/printing_service/enable');
        if ($enablePrint) {
            $url = $subject->getUrl('dhlparcel_shipping/shipment/print', ['shipment_id' => $shipmentId]);
            $subject->addButton(
                'dhlparcel_shipping_print',
                [
                    'label'   => __('Print DHL Labels'),
                    'class'   => 'dhlparcel_shipping_print',
                    'onclick' => "setLocation('$url')"
                ],
                102
            );
        }

        $enableSaveRequest = $this->helper->getConfigData('debug/save_label_requests');
        $enableDebug = $this->helper->getConfigData('debug/enabled');
        if ($enableSaveRequest && $enableDebug) {
            $url = $subject->getUrl('dhlparcel_shipping/shipment/labelrequest', ['shipment_id' => $shipmentId]);
            $subject->addButton(
                'dhlparcel_shipping_request',
                [
                    'label'   => __('DHL Label Request'),
                    'class'   => 'dhlparcel_shipping_request',
                    'onclick' => "setLocation('$url')"
                ],
                102
            );
        }
    }
}
