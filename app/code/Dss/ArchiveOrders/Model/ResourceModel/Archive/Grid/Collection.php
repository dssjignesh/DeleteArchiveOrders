<?php

declare(strict_types=1);
/**
 * Digit Software Solutions.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * @category  Dss
 * @package   Dss_ArchiveOrders
 * @author    Extension Team
 * @copyright Copyright (c) 2024 Digit Software Solutions. ( https://digitsoftsol.com )
 */
namespace Dss\ArchiveOrders\Model\ResourceModel\Archive\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Dss\ArchiveOrders\Model\ResourceModel\Archive\Collection as ArchiveCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Select;
use Magento\Framework\Api\ExtensibleDataInterface;

class Collection extends ArchiveCollection implements SearchResultInterface
{
    /**
     * Main table primary key field name
     *
     * @var string
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @var AggregationInterface
     */
    public $aggregations;

    /**
     * Flag for mass action
     *
     * @var bool
     */
    protected $massActionFlag = false;

    /**
     * Collection constructor.
     *
     * @param EntityFactoryInterface $entityFactory
     * @param LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param StoreManagerInterface $storeManager
     * @param MetadataPool $metadataPool
     * @param string $mainTable
     * @param string $eventPrefix
     * @param string $eventObject
     * @param string $resourceModel
     * @param string $model
     * @param AdapterInterface|string|null $connection
     * @param AbstractDb|null $resource
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        StoreManagerInterface $storeManager,
        MetadataPool $metadataPool,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = Document::class,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    /**
     * Set flag for mass action
     *
     * @param bool $flag
     * @return void
     */
    public function setMassActionFlag(bool $flag): void
    {
        $this->massActionFlag = $flag;
    }

    /**
     * Get aggregations
     *
     * @return AggregationInterface
     */
    public function getAggregations(): AggregationInterface
    {
        return $this->aggregations;
    }

    /**
     * Set aggregations
     *
     * @param AggregationInterface $aggregations
     * @return $this
     */
    public function setAggregations($aggregations): self
    {
        $this->aggregations = $aggregations;
        return $this;
    }

    /**
     * Get search criteria.
     *
     * @return SearchCriteriaInterface|null
     */
    public function getSearchCriteria()
    {
        return null;
    }

    /**
     * Set search criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null): self
    {
        return $this;
    }

    /**
     * Get total count.
     *
     * @return int
     */
    public function getTotalCount(): int
    {
        return $this->getSize();
    }

    /**
     * Set total count.
     *
     * @param int $totalCount
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setTotalCount($totalCount): self
    {
        return $this;
    }

    /**
     * Set items list.
     *
     * @param ExtensibleDataInterface[] $items
     * @return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function setItems(array $items = null): self
    {
        return $this;
    }

    /**
     * Add sales order grid table to collection
     *
     * @return $this
     */
    public function joinSalesOrdeGridTable(): self
    {
        $this->getSelect()->joinLeft(
            ['order_grid_table' => $this->getTable("sales_order_grid")],
            'main_table.order_id = order_grid_table.entity_id'
        );
        $this->addFieldToFilter('main_table.order_id', ['notnull' => true]);
        return $this;
    }

    /**
     * Get all order ids
     *
     * @return array
     */
    public function getAllIds(): array
    {
        if ($this->massActionFlag) {
            $idsSelect = clone $this->getSelect();
            $idsSelect->reset(Select::ORDER);
            $idsSelect->reset(Select::LIMIT_COUNT);
            $idsSelect->reset(Select::LIMIT_OFFSET);
            $idsSelect->reset(Select::COLUMNS);
            $idsSelect->columns($this->_idFieldName, 'order_grid_table');
            return $this->getConnection()->fetchCol($idsSelect, $this->_bindParams);
        } else {
            return parent::getAllIds();
        }
    }
}
