package com.podd.model;

import java.io.Serializable;

/**
 * Created by Shalini Bishnoi on 17-12-2016.
 */
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
