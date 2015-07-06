<?php

namespace Services\Db;

interface iModel
{
    function all();

    function find($id);

    function save();

    function delete($id);
}