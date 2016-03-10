<?php

namespace Laracodes\Presenter\Traits;

use Laracodes\Presenter\Exceptions\PresenterException;

trait Presentable
{
    /**
     * @var \Laracodes\Presenter\Presenter
     */
    protected $presenterInstance;

    /**
     * @return mixed
     * @throws PresenterException
     */
    public function present()
    {
        if (is_object($this->presenterInstance)) {
            return $this->presenterInstance;
        }

        if (property_exists($this, 'presenter') and class_exists($this->presenter)) {
            return $this->presenterInstance = new $this->presenter($this);
        }

        throw new PresenterException('Property $presenter was not set correctly in '.get_class($this));
    }
}
