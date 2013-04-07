<?php

/**
 * This file is part of the Grido (http://grido.bugyik.cz)
 *
 * Copyright (c) 2011 Petr Bugyík (http://petr.bugyik.cz)
 *
 * For the full copyright and license information, please view
 * the file license.md that was distributed with this source code.
 */

namespace Grido\DataSources;

/**
 * Proxy of data source.
 *
 * @package     Grido
 * @subpackage  DataSources
 * @author      Petr Bugyík
 */
class Proxy extends \Nette\Object implements IDataSource
{
    /** @var array */
    public $callback = array();

    /** @var IDataSource */
    protected $dataSource;

    public function __construct(IDataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    /**
     * @param string $method
     * @return mixed
     */
    protected function call($method)
    {
        $args = func_get_args();
        unset($args[0]);

        return isset($this->callback[$method])
            ? callback($this->callback[$method])->invokeArgs(array($this->dataSource, $args[1]))
            : call_user_func_array(array($this->dataSource, $method), $args[1]);
    }

    /*********************************** interface IDataSource ************************************/

    /**
     * @return array
     */
    public function getData()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $condition
     * @return void
     */
    public function filter(array $condition)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return void
     */
    public function limit($offset, $limit)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }

    /**
     * @param array $sorting
     * @return void
     */
    public function sort(array $sorting)
    {
        return $this->call(__FUNCTION__, func_get_args());
    }
}
