package com.podd.model;

import java.io.Serializable;

public class Pagination implements Serializable{

    /**
     * The Page number.
     */
    public String page_number;
    /**
     * The Page size.
     */
    public String page_size;
    /**
     * The Max page number.
     */
    public int max_page_number;
    /**
     * The Total record count.
     */
    public int total_record_count;
}
