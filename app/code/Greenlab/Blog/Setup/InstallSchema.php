<?php
namespace Greenlab\Blog\Setup;

use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->createPostTable($setup);
        $this->createPostProductTable($setup);
        $setup->endSetup();
    }

    /**
     * Create bf_blog_post_product table
     *
     * @param $setup
     */
    protected function createPostProductTable($setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable('bf_blog_post_product')
        )->addColumn(
            'post_id',
            Table::TYPE_INTEGER,
            11,
            ['nullable' => false, 'primary' => true],
            'Post ID'
        )->addColumn(
            'product_id',
            Table::TYPE_INTEGER,
            11,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Product ID'
        )->setComment(
            'Boolfly Blog Post To Product Linkage Table'
        );
        $setup->getConnection()->createTable($table);
    }

    /**
     * Create bf_blog_post table
     *
     * @param $setup
     */
    protected function createPostTable($setup)
    {
        $table = $setup->getConnection()->newTable(
            $setup->getTable('bf_blog_post')
        )->addColumn(
            'post_id',
            Table::TYPE_INTEGER,
            11,
            ['identity' => true, 'nullable' => false, 'primary' => true],
            'Post ID'
        )->addColumn(
            'title',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Post Title'
        )->addColumn(
            'url_key',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'URL Key'
        )->addColumn(
            'image',
            Table::TYPE_TEXT,
            255,
            ['nullable' => false],
            'Image'
        )->addColumn(
            'short_content',
            Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'Short Content'
        )->addColumn(
            'content',
            Table::TYPE_TEXT,
            '2M',
            ['nullable' => false],
            'Content'
        )->addColumn(
            'is_active',
            Table::TYPE_SMALLINT,
            null,
            ['nullable' => false],
            'Is Post Active'
        )->addColumn(
            'creation_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT],
            'Post Creation Time'
        )->addColumn(
            'update_time',
            Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => false, 'default' => Table::TIMESTAMP_INIT_UPDATE],
            'Post Modification Time'
        )->addIndex(
            $setup->getIdxName(
                $setup->getTable('bf_blog_post'),
                ['title'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            ),
            ['title'],
            ['type' => AdapterInterface::INDEX_TYPE_FULLTEXT]
        )->setComment(
            'Boolfly Blog Post Table'
        );
        $setup->getConnection()->createTable($table);
    }

}
