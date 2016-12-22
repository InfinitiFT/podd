package com.podd.model;

import java.io.Serializable;
import java.util.List;

/**
 * Created by Shalini Bishnoi on 17-12-2016.
 */
public class Restaurant implements Serializable{

    /**
     * The Restaurant id.
     */
    public String restaurant_id;
    /**
     * The Restaurant name.
     */
    public String restaurant_name;
    /**
     * The Location.
     */
    public String location;
    public String price_range;
    /**
     * The Postcode.
     */
    public String postcode;
    /**
     * The Latitude.
     */
    public String latitude;
    /**
     * The Longitude.
     */
    public String longitude;
    /**
     * The Restaurant images.
     */
    public String restaurant_images;
    /**
     * The Deliver food.
     */
    public String deliver_food;
    /**
     * The Opening time.
     */
    public String opening_time;
    /**
     * The Closing time.
     */
    public String closing_time;
    /**
     * The About text.
     */
    public String about_text;
    /**
     * The Max people allowed.
     */
    public String max_people_allowed;
    /**
     * The Cuisine.
     */
    public List<Cuisine>cuisine;
    /**
     * The Ambience.
     */
    public List<Ambience>ambience;
    /**
     * The Dietary.
     */
    public List<Dietary>dietary;
    /**
     * The Distance.
     */
    public String distance;
}