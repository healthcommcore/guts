<?php

/**
 * RokGallery_Model_Base_File
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $filename
 * @property char $guid
 * @property char $md5
 * @property string $title
 * @property string $description
 * @property string $license
 * @property integer $xsize
 * @property integer $ysize
 * @property integer $filesize
 * @property char $type
 * @property boolean $published
 * @property RokGallery_Model_FileLoves $Loves
 * @property RokGallery_Model_FileViews $Views
 * @property Doctrine_Collection $Slices
 * @property Doctrine_Collection $Tags
 * 
 * @package    RokGallery
 * @subpackage models
 * @author     RocketTheme LLC <support@rockettheme.com>
 * @version    SVN: $Id$
 */
abstract class RokGallery_Model_Base_File extends RokCommon_Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('rokgallery_files');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'primary' => true,
             'unique' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('filename', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('guid', 'char', 36, array(
             'type' => 'char',
             'notnull' => true,
             'unique' => true,
             'length' => '36',
             ));
        $this->hasColumn('md5', 'char', 32, array(
             'type' => 'char',
             'notnull' => true,
             'length' => '32',
             ));
        $this->hasColumn('title', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '200',
             ));
        $this->hasColumn('description', 'string', null, array(
             'type' => 'string',
             'length' => '',
             ));
        $this->hasColumn('license', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('xsize', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('ysize', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('filesize', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => true,
             'notnull' => true,
             'length' => '4',
             ));
        $this->hasColumn('type', 'char', 20, array(
             'type' => 'char',
             'notnull' => true,
             'length' => '20',
             ));
        $this->hasColumn('published', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             'notnull' => true,
             ));


        $this->index('rokgallery_files_published', array(
             'fields' => 
             array(
              0 => 'published',
             ),
             ));
        $this->index('rokgallery_files_md5', array(
             'fields' => 
             array(
              0 => 'md5',
             ),
             ));
        $this->index('rokgallery_files_guid', array(
             'fields' => 
             array(
              0 => 'guid',
             ),
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('RokGallery_Model_FileLoves as Loves', array(
             'local' => 'id',
             'foreign' => 'file_id'));

        $this->hasOne('RokGallery_Model_FileViews as Views', array(
             'local' => 'id',
             'foreign' => 'file_id'));

        $this->hasMany('RokGallery_Model_Slice as Slices', array(
             'local' => 'id',
             'foreign' => 'file_id',
             'orderBy' => 'admin_thumb ASC, title ASC'));

        $this->hasMany('RokGallery_Model_FileTags as Tags', array(
             'local' => 'id',
             'foreign' => 'file_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'unique' => true,
             'fields' => 
             array(
              0 => 'title',
             ),
             ));
        $searchable0 = new Doctrine_Template_Searchable(array(
             'fields' => 
             array(
              0 => 'title',
              1 => 'description',
             ),
             'tableName' => '%TABLE%_index',
             'builderOptions' => 
             array(
              'baseClassName' => 'RokCommon_Doctrine_Record',
              'baseTableClassName' => 'RokCommon_Doctrine_Table',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($sluggable0);
        $this->actAs($searchable0);
    }
}