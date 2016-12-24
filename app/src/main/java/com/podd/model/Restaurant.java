package com.podd.model;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by Shalini Bishnoi on 17-12-2016.
 */
public class Restaurant implements Serializable{

    public String restaurant_id;
    public String restaurant_name;
    public String location;
    public String price_range;
    public String postcode;
    public String latitude;
    public String longitude;
    public ArrayList<String>restaurant_images;
    public String deliver_food;
    public String opening_time;
    public String closing_time;
    public String about_text;
    public String max_people_allowed;
    public List<Cuisine>cuisine;
    public List<Ambience>ambience;
    public List<Dietary>dietary;
    public String distance;
}