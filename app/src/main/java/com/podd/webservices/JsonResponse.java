package com.podd.webservices;

import com.podd.model.Cuisine;
import com.podd.model.Pagination;
import com.podd.model.Restaurant;

import java.io.Serializable;
import java.util.List;


public class JsonResponse implements Serializable{


    public String responseCode;
    public String responseMessage;


    /*   Restaurant List api response */

    public List<Restaurant> restaurant_list;
    public Pagination pagination;

    /* Cuisine Restaurant List */

    public List<Cuisine> allList;





}
