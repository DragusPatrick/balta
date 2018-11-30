<?php



defined('BASEPATH') OR exit('No direct script access allowed');



class Data_tables

{



    public function __get($var)

    {

        return get_instance()->$var;

    }



    /**

     * Create the data output array for the DataTables rows

     *

     *  @param  array $columns Column information array

     *  @param  array $data    Data from the SQL get

     *  @return array          Formatted data in a row based format

     */

    private function data_output($columns, $data)

    {

        $out = array();



        for($i = 0, $ien = count($data); $i < $ien; $i++)

        {

            $row = array();



            for($j = 0, $jen = count($columns); $j < $jen; $j++)

            {

                $column = $columns[$j];



                if(isset($column['formatter']))

                {

                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);

                }

                else

                {

                    $row[$column['dt']] = $data[$i][$columns[$j]['db']];

                }

            }



            $out[] = $row;

        }



        return $out;

    }



    /**

     * Create the data output array for the DataTables rows

     *

     *  @param  array $columns Column information array

     *  @param  array $data    Data from the SQL get

     *  @return array          Formatted data in a row based format

     */

    private function complex_data_output($columns, $data)

    {

        $out = array();

		

        for($i = 0, $ien = count($data); $i < $ien; $i++)

        {

            $row = array();



            for($j = 0, $jen = count($columns); $j < $jen; $j++)

            {

                $column = $columns[$j];



                if(isset($column['formatter']))

                {

                    $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);

                }

                else

                {

                    $row[$column['dt']] = $data[$i][$columns[$j]['db']];

                }

            }



            $out[] = $row;

        }



        return $out;

    }



    /**

     * Paging

     *

     * Construct the LIMIT clause for server-side processing SQL query

     *

     *  @param  array $request Data sent to server by DataTables

     *  @return string SQL limit clause

     */



    private function limit($request)

    {

        $limit = '';



        if(isset($request['start']) && $request['length'] != -1)

        {

            $limit = "LIMIT ".intval($request['start']).", ".intval($request['length']);

        }



        return $limit;

    }



    /**

     * Ordering

     *

     * Construct the ORDER BY clause for server-side processing SQL query

     *

     *  @param  array $request Data sent to server by DataTables

     *  @param  array $columns Column information array

     *  @return string SQL order by clause

     */

    private function order($request, $columns)

    {

        $order = '';



        if(isset($request['order']) && count($request['order']))

        {

            $orderBy    = array();

            $dtColumns  = $this->pluck($columns, 'dt');



            for($i = 0, $ien = count($request['order']); $i < $ien ; $i++)

            {

                $columnIdx      = intval($request['order'][$i]['column']);

                $requestColumn  = $request['columns'][$columnIdx];

                $columnIdx      = array_search( $requestColumn['data'], $dtColumns);

                $column         = $columns[$columnIdx];



                if($requestColumn['orderable'] == 'true')
                {
                    $dir = $request['order'][$i]['dir'] === 'asc' ? 'ASC' : 'DESC';
                    $orderBy[] = $column['db'].' '.$dir;
                }
            }

            $order = 'ORDER BY '.implode(', ', $orderBy);
        }
        return $order;
    }

    /**

     * Searching / Filtering

     *

     * Construct the WHERE clause for server-side processing SQL query.

     *

     * NOTE this does not match the built-in DataTables filtering which does it

     * word by word on any field. It's possible to do here performance on large

     * databases would be very poor

     *

     *  @param  array $request Data sent to server by DataTables

     *  @param  array $columns Column information array

     *  @return string SQL where clause

     */

    private function filter($request, $columns)

    {

        $globalSearch   = array();

        $columnSearch   = array();

        $dtColumns      = $this->pluck($columns, 'dt');



        if(isset($request['search']) && $request['search']['value'] != '')

        {

            $str = $request['search']['value'];



            for($i = 0, $ien = count($request['columns']); $i<$ien; $i++)

            {

                $requestColumn  = $request['columns'][$i];

                $columnIdx      = array_search($requestColumn['data'], $dtColumns);

                $column         = $columns[$columnIdx];

                if($requestColumn['searchable'] == 'true')
                {
                    $globalSearch[] = "`".$column['db']."` LIKE '%" . $this->db->escape_like_str($str) . "%'";
                }
            }
        }


        for($i = 0, $ien = count($request['columns']); $i < $ien; $i++ )
        {
            $requestColumn  = $request['columns'][$i];

            $columnIdx      = array_search( $requestColumn['data'], $dtColumns );

            $column         = $columns[ $columnIdx ];

            $str            = $requestColumn['search']['value'];



            if($requestColumn['searchable'] == 'true' && $str != '')

            {

                $columnSearch[] = "`".$column['db']."` LIKE '%" . $this->db->escape_like_str($str) . "%'";

            }

        }



        $where = '';



        if(count($globalSearch))

        {

            $where = '('.implode(' OR ', $globalSearch).')';

        }



        if(count($columnSearch))

        {

            $where = $where === '' ?

                implode(' AND ', $columnSearch) :

                $where .' AND '. implode(' AND ', $columnSearch);

        }



        if($where !== '')

        {

            $where = 'WHERE '.$where;

        }



        return $where;

    }



    /**

     * Perform the SQL queries needed for an server-side processing requested,

     * utilising the helper functions of this class, limit(), order() and

     * filter() among others. The returned array is ready to be encoded as JSON

     * in response to an SSP request, or can be modified if needed before

     * sending back to the client.

     *

     *  @param  array $request Data sent to server by DataTables

     *  @param  string $table SQL table to query

     *  @param  string $primaryKey Primary key of the table

     *  @param  array $columns Column information array

     *  @return array Server-side processing response array

     */

    public function simple($request, $table, $primaryKey, $columns)

    {

        $limit = $this->limit($request, $columns);

        $order = $this->order($request, $columns);

        $where = $this->filter($request, $columns);



        $data = $this->db->query("SELECT SQL_CALC_FOUND_ROWS `".implode("`, `", $this->pluck($columns, 'db'))."` FROM `$table` $where $order $limit")->result_array();



        $recordsFiltered = $this->db->query("SELECT FOUND_ROWS() AS fr")->row()->fr;



        $recordsTotal = $this->db->query("SELECT COUNT(`{$primaryKey}`) AS rt FROM `$table`")->row()->rt;



        return array(

            "draw"            => intval($request['draw']),

            "recordsTotal"    => intval($recordsTotal),

            "recordsFiltered" => intval($recordsFiltered),

            "data"            => $this->data_output($columns, $data)

        );

    }



    /**

     * The difference between this method and the `simple` one, is that you can

     * apply additional `where` conditions to the SQL queries. These can be in

     * one of two forms:

     *

     * * 'Result condition' - This is applied to the result set, but not the

     *   overall paging information query - i.e. it will not effect the number

     *   of records that a user sees they can have access to. This should be

     *   used when you want apply a filtering condition that the user has sent.

     * * 'All condition' - This is applied to all queries that are made and

     *   reduces the number of records that the user can access. This should be

     *   used in conditions where you don't want the user to ever have access to

     *   particular records (for example, restricting by a login id).

     *

     *  @param  array $request Data sent to server by DataTables

     *  @param  string $table SQL table to query

     *  @param  string $primaryKey Primary key of the table

     *  @param  array $columns Column information array

     *  @param  string $whereResult WHERE condition to apply to the result set

     *  @param  string $whereAll WHERE condition to apply to all queries

     *  @return array Server-side processing response array

     */

    public function complex($request, $table, $primaryKey, $columns, $whereResult = null, $whereAll = null)

    {

        $whereAllSql = '';



        $limit = $this->limit($request, $columns);

        $order = $this->order($request, $columns);

        $where = $this->filter($request, $columns);



        $whereResult = $this->_flatten($whereResult);
		
        $whereAll    = $this->_flatten($whereAll);



        if($whereResult)

        {

            $where = $where ?

                $where .' AND '.$whereResult :

                'WHERE '.$whereResult;

        }
		
    


        if ($whereAll)

        {

            $where = $where ?

                $where .' AND '.$whereAll :

                'WHERE '.$whereAll;



            $whereAllSql = 'WHERE '.$whereAll;

        }



        $data = $this->db->query("SELECT SQL_CALC_FOUND_ROWS ".implode(", ", $this->pluck($columns, 'db'))." FROM $table $where $order $limit")->result_array();

	

        $recordsFiltered = $this->db->query("SELECT FOUND_ROWS() AS fr")->row()->fr;



        $recordsTotal = $this->db->query("SELECT COUNT({$primaryKey}) AS rt FROM  $table ". $whereAllSql)->row()->rt;



        return array(

            "draw"            => intval($request['draw']),

            "recordsTotal"    => intval($recordsTotal),

            "recordsFiltered" => intval($recordsFiltered),

            "data"            => $this->complex_data_output($columns, $data)

        );

    }



    /**

     * Pull a particular property from each assoc. array in a numeric array,

     * returning and array of the property values from each item.

     *

     *  @param  array  $a    Array to get data from

     *  @param  string $prop Property to read

     *  @return array        Array of property values

     */

    private function pluck($a, $prop)

    {

        $out = array();



        for($i = 0, $len = count($a); $i < $len ; $i++)

        {

            $out[] = $a[$i][$prop];

        }



        return $out;

    }



    /**

     * Return a string from an array or a string

     *

     * @param  array|string $a Array to join

     * @param  string $join Glue for the concatenation

     * @return string Joined string

     */

    private function _flatten($a, $join = ' AND ')

    {

        if(!$a)

        {

            return '';

        }

        else if(is_array($a))

        {

            return implode( $join, $a );

        }



        return $a;

    }

}

