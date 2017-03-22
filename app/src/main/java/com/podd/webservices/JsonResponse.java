package com.podd.webservices;

import com.podd.model.Ambience;
import com.podd.model.Cuisine;
import com.podd.model.Dietary;
import com.podd.model.HomeImageModel;
import com.podd.model.HomeItemsModel;
import com.podd.model.Pagination;
import com.podd.model.PlaceApiAddress;
import com.podd.model.Restaurant;
import com.podd.model.RestaurantMenu;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;


public class JsonResponse implements Serializable{

    public String responseCode;
    public String responseMessage;
    public String verification_status;
    /*   Restaurant List api response */

    public List<Restaurant> restaurant_list;
    public Pagination pagination;

    /* Cuisine Restaurant List */

    public List<Cuisine> allList;

    /*   Restaurant Details  */

    public String restaurant_id;
    public String restaurant_name;
    public String location;
    public String message;
    public String postcode;
    public String latitude;
    public String longitude;
    public String deliver_food;
    public String opening_time;
    public String closing_time;
    public String price_range;
    public String distance;
    public String about_text;
    public String name;
    public String page_data;
    public String max_people_allowed;
    public List<Cuisine>cuisine;
    public List<Dietary>dietary;
    public List<Ambience>ambience;
    public List<RestaurantMenu>restaurant_menu;
    public ArrayList<String> restaurant_images;


    /*   Restaurant time interval  */

    public List<String> restaurant_time_interval;
    public List<HomeItemsModel> allServiceList;
    public List<HomeImageModel> homePageData;
    public List<PlaceApiAddress> results;


}
