<?php
/**
 * Leandro Rosa
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Doris Module to newer
 * versions in the future. If you wish to customize it for your
 * needs please refer to https://developer.adobe.com/commerce/docs/ for more information.
 *
 * @category LeandroRosa
 *
 * @copyright Copyright (c) 2024 Leandro Rosa (https:www.rosa-planet.com.br)
 *
 * @author Leandro Rosa <dev.leandrorosa@gmail.com>
 */
declare(strict_types=1);

namespace LeandroRosa\DorisCatalogIntegrator\Block\Adminhtml\Form\Field;


use LeandroRosa\DorisCatalogIntegrator\Block\Adminhtml\Form\Field\DorisCategory;
use LeandroRosa\DorisCatalogIntegrator\Block\Adminhtml\Form\Field\WebsiteCategory;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\LocalizedException;

class CategoriesAssociation extends AbstractFieldArray
{
    /**
     * @var WebsiteCategory|null
     */
    protected ?WebsiteCategory $websiteCategoryRender;

    /**
     * @var DorisCategory|null
     */
    protected ?DorisCategory $dorisCategoryRender;

    /**
     * @var Gender|null
     */
    protected ?Gender $genderRender;

    /**
     * @inheritDoc
     *
     * @return void
     *
     * @throws LocalizedException
     */
    protected function _prepareToRender(): void
    {
        $this->addColumn('website_category', [
            'label' => __('Website Category'),
            'renderer' => $this->getWebsiteCategoryRender(),
        ]);
        $this->addColumn('doris_category', [
            'label' => __('Doris Category'),
            'renderer' => $this->getDorisCategoriesRender()
        ]);
        $this->addColumn('doris_gender', [
            'label' => __('Gender'),
            'renderer' => $this->getGenderRender()
        ]);
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Category Association');
    }

    /**
     * @inheritDoc
     *
     * @param DataObject $row
     *
     * @return void
     *
     * @throws LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row): void
    {
        $options = [];
        $websiteCategoryRender = $this->getWebsiteCategoryRender();
        $dorisCategoryRender = $this->getDorisCategoriesRender();
        $genderRender = $this->getGenderRender();

        $websiteCategoryId = $row->getData('website_category_id');
        if ($websiteCategoryId) {
            $options['option_' . $websiteCategoryRender->calcOptionHash($websiteCategoryId)] = 'selected="selected"';
        }

        $dorisCategory = $row->getData('doris_category');

        if (!empty($dorisCategory['doris_gender'])) {
            $gender = $dorisCategory['doris_gender'];
            unset($dorisCategory['doris_gender']);
            $options['option_' . $genderRender->calcOptionHash($gender)] = 'selected="selected"';
        }

        if ($dorisCategory) {
            $options['option_' . $dorisCategoryRender->calcOptionHash(json_encode($dorisCategory))] = 'selected="selected"';
        }


        $row->setData('option_extra_attrs', $options);
        $row->setData('_id', "doris-association-{$row->getData('_id')}");
    }

    /**
     * @return DorisCategory
     *
     * @throws LocalizedException
     */
    protected function getDorisCategoriesRender(): DorisCategory
    {
        if (empty($this->dorisCategoryRender)) {
            $this->dorisCategoryRender = $this->getLayout()->createBlock(
                DorisCategory::class,
                'doris_category',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->dorisCategoryRender;
    }

    /**
     * @return WebsiteCategory
     *
     * @throws LocalizedException
     */
    protected function getWebsiteCategoryRender(): WebsiteCategory
    {
        if (empty($this->websiteCategoryRender)) {
            $this->websiteCategoryRender = $this->getLayout()->createBlock(
                WebsiteCategory::class,
                'website_category',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->websiteCategoryRender;
    }

    /**
     * @return WebsiteCategory
     *
     * @throws LocalizedException
     */
    protected function getGenderRender(): Gender
    {
        if (empty($this->genderRender)) {
            $this->genderRender = $this->getLayout()->createBlock(
                Gender::class,
                'doris_gender',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }
        return $this->genderRender;
    }
}
