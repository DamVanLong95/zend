<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace FormTest\Form;

use PHPUnit\Framework\TestCase;
use Zend\Validator\File;

/**
 * IsImage testbed
 *
 * @group      Zend_Validator
 */
class IsImageTest extends TestCase
{

    public function basicBehaviorDataProvider()
    {
        $testFile = __DIR__ . '/_files/picture.jpg';
        $fileUpload = [
            'tmp_name' => $testFile, 'name' => basename($testFile),
            'size' => 200, 'error' => 0, 'type' => 'image/jpeg'
        ];
        return [
            //    Options, isValid Param, Expected value
            [null,                              $fileUpload, true],
            ['jpeg',                            $fileUpload, true],
            ['test/notype',                     $fileUpload, false],
            ['image/gif, image/jpeg',           $fileUpload, true],
            [['image/vasa', 'image/jpeg'], $fileUpload, true],
            [['image/jpeg', 'gif'],        $fileUpload, true],
            [['image/gif', 'gif'],         $fileUpload, false],
            ['image/jp',                        $fileUpload, false],
            ['image/jpg2000',                   $fileUpload, false],
            ['image/jpeg2000',                  $fileUpload, false],
        ];
    }

    /**
     * Ensures that the validator follows expected behavior
     *
     * @dataProvider basicBehaviorDataProvider
     * @return void
     */
    public function testBasic($options, $isValidParam, $expected)
    {
        $validator = new File\IsImage($options);
        $validator->enableHeaderCheck();
        $this->assertEquals($expected, $validator->isValid($isValidParam));
    }

    /**
     * @ZF-8111
     */
    public function testErrorMessages()
    {
        $files = [
            'name'     => 'picture.jpg',
            'type'     => 'image/jpeg',
            'size'     => 200,
            'tmp_name' => __DIR__ . '/_files/picture.jpg',
            'error'    => 0
        ];

        $validator = new File\IsImage('test/notype');
        $validator->enableHeaderCheck();
        $this->assertFalse($validator->isValid(__DIR__ . '/_files/picture.jpg', $files));
        $error = $validator->getMessages();
        $this->assertArrayHasKey('fileIsImageFalseType', $error);
    }
}
