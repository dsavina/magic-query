<?php

namespace SQLParser;

class ExpressionToken
{
    private $subTree;
    private $expression;
    private $key;
    private $token;
    private $tokenType;
    private $trim;
    private $upper;

    public function __construct($key = '', $token = '')
    {
        $this->subTree = false;
        $this->expression = '';
        $this->key = $key;
        $this->token = $token;
        $this->tokenType = false;
        $this->trim = trim($token);
        $this->upper = strtoupper($this->trim);
    }

    # TODO: we could replace it with a constructor new ExpressionToken(this, "*")
    public function addToken($string)
    {
        $this->token .= $string;
    }

    public function isEnclosedWithinParenthesis()
    {
        return ($this->upper[0] === '(' && substr($this->upper, -1) === ')');
    }

    public function setSubTree($tree)
    {
        $this->subTree = $tree;
    }

    public function getSubTree()
    {
        return $this->subTree;
    }

    public function getUpper($idx = false)
    {
        return $idx !== false ? $this->upper[$idx] : $this->upper;
    }

    public function getTrim($idx = false)
    {
        return $idx !== false ? $this->trim[$idx] : $this->trim;
    }

    public function getToken($idx = false)
    {
        return $idx !== false ? $this->token[$idx] : $this->token;
    }

    public function setTokenType($type)
    {
        $this->tokenType = $type;
    }

    public function endsWith($needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }

        $start = $length * -1;

        return (substr($this->token, $start) === $needle);
    }

    public function isWhitespaceToken()
    {
        return ($this->trim === '');
    }

    public function isCommaToken()
    {
        return ($this->trim === ',');
    }

    public function isVariableToken()
    {
        return $this->upper[0] === '@';
    }

    public function isSubQueryToken()
    {
        return preg_match('/^\\(\\s*SELECT/i', $this->trim);
    }

    public function isExpression()
    {
        return $this->tokenType === ExpressionType::EXPRESSION;
    }

    public function isBracketExpression()
    {
        return $this->tokenType === ExpressionType::BRACKET_EXPRESSION;
    }

    public function isOperator()
    {
        return $this->tokenType === ExpressionType::OPERATOR;
    }

    public function isInList()
    {
        return $this->tokenType === ExpressionType::IN_LIST;
    }

    public function isFunction()
    {
        return $this->tokenType === ExpressionType::SIMPLE_FUNCTION;
    }

    public function isUnspecified()
    {
        return ($this->tokenType === false);
    }

    public function isAggregateFunction()
    {
        return $this->tokenType === ExpressionType::AGGREGATE_FUNCTION;
    }

    public function isColumnReference()
    {
        return $this->tokenType === ExpressionType::COLREF;
    }

    public function isConstant()
    {
        return $this->tokenType === ExpressionType::CONSTANT;
    }

    public function isSign()
    {
        return $this->tokenType === ExpressionType::SIGN;
    }

    public function isSubQuery()
    {
        return $this->tokenType === ExpressionType::SUBQUERY;
    }

    public function toArray()
    {
        return array('expr_type' => $this->tokenType, 'base_expr' => $this->token, 'sub_tree' => $this->subTree);
    }
}
