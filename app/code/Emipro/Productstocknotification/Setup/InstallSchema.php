<?php
namespace Emipro\Productstocknotification\Setup;
 
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
 
 
class InstallSchema implements InstallSchemaInterface
{
     
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

//emipro_stock_notification
        $table = $installer->getConnection()->newTable(
            $installer->getTable('emipro_stock_notification')
        )->addColumn(
            'id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array(
                'identity' => true, 
                'nullable' => false, 
                'primary' => true,
                'unsigned' => true
                ),
            'Grid Record Id'
        )->addColumn('product_id', 
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER, 
            null, 
            array(
                'unsigned'  => true,
                ), 
                'Product Id'
        )->addColumn('email_id', 
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT, 
            255, 
            array(
                'nullable'  => true,
                'default'   => null,
                ), 
                'Email Id'
        )->addColumn('created_at', 
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP, 
            null, 
            [], 
            'Stock Notication Created At'
        )->setComment(
            'Emipro Product Option Table'
        );
        
        $installer->getConnection()->createTable($table);

        $installer->endSetup();
    }
}