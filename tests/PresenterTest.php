<?php

use Laracodes\Presenter\Presenter;
use Laracodes\Presenter\Traits\Presentable;
use Illuminate\Database\Eloquent\Model;

class PresenterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Product
     */
    protected $model;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->model = new Product();
    }

    /**
     * @test
     */
    public function propertyModelExistsInPresenterClass()
    {
        $this->assertAttributeInstanceOf(Model::class, 'model', $this->model->present());
    }

    /**
     * @test
     */
    public function presenterModifyCorrectlyProperty()
    {
        $this->assertEquals('Product 1', $this->model->present()->name);
        $this->assertStringStartsWith('$', $this->model->present()->price);
    }

    /**
     * @test
     */
    public function callPropertyInModelIfNotExistsInPresenter()
    {
        $this->assertEquals('description of product 1', $this->model->present()->description);
    }

    /**
     * @test
     */
    public function propertyIssetInPresenterClass()
    {
        $this->assertTrue(isset($this->model->present()->name));
        $this->assertTrue(isset($this->model->present()->short_name));
        $this->assertTrue(isset($this->model->present()->shortName));
        $this->assertFalse(isset($this->model->present()->description));
    }

    /**
     * @test
     */
    public function propertyInSnakeCaseConvertedToCamelCase()
    {
        $this->assertEquals('Product...', $this->model->present()->short_name);
    }

    /**
     * @test
     */
    public function callPropertyInModelIfNotExistsInPresenterWithConversionToSnakeCase()
    {
        $expected = 'testing';

        $this->assertEquals($expected, $this->model->present()->property_test);
        $this->assertEquals($expected, $this->model->present()->propertyTest);
    }
}

class Product extends Model
{
    use Presentable;

    protected $presenter = ProductPresenter::class;

    protected $attributes = [
        'name' => 'product 1',
        'description' => 'description of product 1',
        'price' => 9.90,
        'property_test' => 'testing'
    ];
}

class ProductPresenter extends Presenter
{
    public function name()
    {
        return ucfirst($this->model->name);
    }

    public function shortName()
    {
        return str_limit($this->name(), 7);
    }

    public function price()
    {
        return '$' . $this->model->price;
    }
}
