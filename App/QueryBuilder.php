<?php

namespace App;

class QueryBuilder
{
    protected string $table;
    protected array|string $columns;
    protected array $wheres;
    protected array $bindings = [];

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function select(string|array $columns)
    {
        $this->columns = $columns;
        return $this;
    }

    public function where(string $column, string $operator, $value, $logicalOperator = 'and')
    {
        $this->wheres[] = [
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
            'logicalOperator' => $logicalOperator
        ];

        return $this;
    }

    public function orWhere(string $column, string $operator, $value)
    {
        $this->where($column, $operator, $value, 'or');

        return $this;
    }

    protected function buildSelectClause()
    {
        $stmt = "SELECT ";

        if (!is_array($this->columns)) {
            $stmt .= "{$this->columns}";
        } else {
            foreach ($this->columns as $column) {
                $stmt .= "{$column}, ";
            }

            $stmt = rtrim($stmt, ', ');
        }

        return $stmt;
    }

    protected function buildFromClause()
    {
        return "FROM {$this->table}";
    }

    protected function buildWhereClause()
    {
        $whereClause = "";

        foreach ($this->wheres as $where) {
            // $whereClause .= " {$where['logicalOperator']} {$where['column']} {$where['operator']} {$where['value']}";
            $whereClause .= " {$where['logicalOperator']} {$where['column']} {$where['operator']} ?";
            $this->bindings[] = $where['value'];
        }

        return 'WHERE ' . ltrim($whereClause, ' and');
    }

    protected function buildSetClause($values)
    {
        $set = "SET ";

        foreach ($values as $column => $value) {
            $set .= "{$column} = ?, ";
            $this->bindings[] = $value;
        }

        return rtrim($set, ', ');
    }

    public function get()
    {
        return "{$this->buildSelectClause()} {$this->buildFromClause()} {$this->buildWhereClause()}";
    }

    protected function buildInsertCaluse($columns)
    {
        $clause = "INSERT INTO {$this->table} (";
        foreach ($columns as  $column) {
            $clause .= "{$column}, ";
        }
        return rtrim($clause, ', ') . ')';
    }

    protected function buildValuesClause($values)
    {
        $clause = "VALUES (";

        foreach ($values as  $value) {
            $clause .= "?, ";
            $this->bindings[] = $value;
        }

        return rtrim($clause, ', ') . ')';
    }

    public function insert(array $values)
    {
        return "{$this->buildInsertCaluse(array_keys($values))} {$this->buildValuesClause(array_values($values))}";
    }

    public function update(array $values)
    {
        return "UPDATE {$this->table} {$this->buildSetClause($values)} {$this->buildWhereClause()}";
    }

    public function delete()
    {
        return "DELETE {$this->buildFromClause()} {$this->buildWhereClause()}";
    }
}
