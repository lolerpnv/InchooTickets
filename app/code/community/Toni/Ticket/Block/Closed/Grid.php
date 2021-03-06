<?php
class Toni_Ticket_Block_Closed_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct()
    {
        parent::__construct();
        $this->setId('closedGrid');
        // $this->setDefaultSort('COLUMN_ID');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('ticket/ticket')->getCollection()
            ->addFieldToSelect('*')
            ->addFieldToFilter('active',0)
        ;
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

       $this->addColumn('ticket_id',
           array(
               'header'=> $this->__('Ticket_Id'),
               'width' => '5px',
               'index' => 'entity_id'
           )
       );
        $this->addColumn('subject',
            array(
                'header'=> $this->__('Subject'),
                'width' => '100px',
                'index' => 'subject'
            )
        );
        $this->addColumn('message',
            array(
                'header'=> $this->__('Message'),
                'width' => '100px',
                'index' => 'message'
            )
        );

        $this->addExportType('*/*/exportCsv', $this->__('CSV'));

        $this->addExportType('*/*/exportExcel', $this->__('Excel XML'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

    protected function _prepareMassaction()
    {
        $modelPk = Mage::getModel('ticket/ticket')->getResource()->getIdFieldName();
        $this->setMassactionIdField($modelPk);
        $this->getMassactionBlock()->setFormFieldName('ids');
        // $this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->addItem('delete', array(
            'label'=> $this->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete'),
        ));
        return $this;
    }
}
