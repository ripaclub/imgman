<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 22/06/14
 * Time: 11.30
 */

namespace ImgManLibraryTest\Service;

use ImgManLibrary\Service\ServiceImplement;
use ImgManLibraryTest\ImageManagerTestCase;
use ImgManLibraryTest\Service\TestAsset\Container;

class ServiceImplementTest extends ImageManagerTestCase
{
    public function testServiceImplementConstruct()
    {
        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');

        $service = new ServiceImplement($storage, $pluginManager, $adapter);
        $this->assertInstanceOf('ImgManLibrary\Service\ServiceImplement',$service);
    }

    /**
     * @expectedException \ImgManLibrary\Service\Exception\InvalidArgumentException
     */
    public function testServiceImplementCheckIdentifierException()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');

        $service = new ServiceImplement($storage, $pluginManager, $adapter);
        $service->setRegExIdentifier('test');

        $service->save('test/test', $image);
    }

    /**
     * @expectedException \ImgManLibrary\Service\Exception\InvalidArgumentException
     */
    public function testServiceImplementCheckIdentifierException2()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');

        $service = new ServiceImplement($storage, $pluginManager, $adapter);

        $service->save('test/test', $image);
    }

    public function testServiceImplementGetSet()
    {
        $service = new ServiceImplement();
        $service->setRenditions(array('thumb' => array(
                'resize' => array(
                    'width'  => 200,
                    'height' => 200
                )
            )
            )
        );
        $this->assertArrayHasKey('thumb', $service->getRenditions());

        $service->setRegExIdentifier('exprReg');
        $this->assertSame('exprReg', $service->getRegExIdentifier());
    }

    /**
     * @expectedException \ImgManLibrary\Service\Exception\InvalidRenditionException
     */
    public function testServiceImplementSetRenditionException()
    {
        $service = new ServiceImplement();
        $service->setRenditions(array('original' => array('test')));
    }

    public function testServiceImplementSave()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');

        $service = new ServiceImplement($storage, $pluginManager, $adapter);

        $this->assertTrue($service->save('test/test/', $image));
    }

    /**
     * @expectedException ImgManLibrary\Storage\Exception\AlreadyIdExistException
     */
    public function testServiceImplementSaveException()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');

        $service = new ServiceImplement($storage, $pluginManager, $adapter);

        $service->save('test/test/', $image);
    }

    public function testServiceImplementDelete()
    {
        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('deleteImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');
        $service = new ServiceImplement($storage, $pluginManager, $adapter);

        $this->assertTrue($service->delete('test/test/'));

    }

    public function testServiceImplementUpdate()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(true));
        $storage->expects($this->any())
            ->method('updateImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));

        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');

        $service = new ServiceImplement($storage, $pluginManager, $adapter);

        $this->assertTrue($service->update('test/test/', $image));
    }

    /**
     * @expectedException ImgManLibrary\Storage\Exception\NotIdExistException
     */
    public function testServiceImplementUpdateException()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');
        $service = new ServiceImplement($storage, $pluginManager, $adapter);

        $service->update('test/test/', $image);
    }

    public function testServiceImplementGet()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $containerStorage = $this->getMockForAbstractClass('ImgManLibrary\Storage\Image\AbstractImageContainer');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('getImage')
            ->will($this->returnValue($containerStorage));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('getMimeType')
            ->will($this->returnValue('image/png'));

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');
        $service = new ServiceImplement($storage, $pluginManager, $adapter);

        $this->assertSame($containerStorage, $service->get('test/test/', 'thumb'));
    }

    public function testServiceImplementApplyRendition()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $containerStorage = $this->getMockForAbstractClass('ImgManLibrary\Storage\Image\AbstractImageContainer');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));
        /* @var $pluginManager  \Zend\ServiceManager\AbstractPluginManager */
        $helper = $this->getMock('ImgManLibrary\Operation\Helper\Resize');
        $helper->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');
        $pluginManager->expects($this->any())
            ->method('get')
            ->will($this->returnValue($helper));

        $service = new ServiceImplement($storage, $pluginManager, $adapter);
        $service->setRenditions(array(
                'thumb' => array(
                    'resize' => array(
                        'width'  => 200,
                        'height' => 200
                    )
                )
            )
        );

        $this->assertTrue($service->save('test/test/', $image, 'thumb'));
    }

    public function testServiceImplementGrab()
    {
        $image = new Container(__DIR__ . '/../Image/img/test.jpg');

        $containerStorage = $this->getMockForAbstractClass('ImgManLibrary\Storage\Image\AbstractImageContainer');

        $storage =  $this->getMock('ImgManLibrary\Storage\Adapter\Mongo\MongoAdapter');
        $storage->expects($this->any())
            ->method('hasImage')
            ->will($this->returnValue(false));
        $storage->expects($this->any())
            ->method('saveImage')
            ->will($this->returnValue(true));

        $adapter = $this->getMock('ImgManLibrary\Core\Adapter\ImagickAdapter');
        $adapter->expects($this->any())
            ->method('clear')
            ->will($this->returnValue(true));
        $adapter->expects($this->any())
            ->method('getBlob')
            ->will($this->returnValue($image));
        /* @var $pluginManager  \Zend\ServiceManager\AbstractPluginManager */
        $helper = $this->getMock('ImgManLibrary\Operation\Helper\Resize');
        $helper->expects($this->any())
            ->method('execute')
            ->will($this->returnValue(true));

        $pluginManager =  $this->getMock('ImgManLibrary\Operation\OperationPluginManager');
        $pluginManager->expects($this->any())
            ->method('get')
            ->will($this->returnValue($helper));

        $service = new ServiceImplement($storage, $pluginManager, $adapter);
        $service->setRenditions(array(
                'thumb' => array(
                    'resize' => array(
                        'height' => 200,
                        'width'  => 300
                    )
                ),
                'thumbMaxi' => array(
                    'resize' => array(
                        'height' => 200,
                        'width'  => 300
                    )
                ),
            )
        );

        $this->assertSame('test/test/', $service->grab($image, 'test/test/'));
    }
}