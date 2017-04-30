<?php

namespace TomLingham\Searchy\Matchers;


class InsideStartOfWordsMatcher extends BaseMatcher
{
    protected $operator = 'LIKE';

    public function formatSearchString($searchString)
    {
        return '% ' . $searchString . '%';
    }
}
