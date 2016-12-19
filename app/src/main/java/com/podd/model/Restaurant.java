package com.podd.model;

import java.util.List;

/**
 * Created by Shalini Bishnoi on 17-12-2016.
 */
public class Restaurant {

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
    public List<String>cuisine;
    /**
     * The Ambience.
     */
    public List<String>ambience;
    /**
     * The Dietary.
     */
    public List<String>dietary;
    /**
     * The Price range.
     */
    public List<String>price_range;
    /**
     * The Distance.
     */
    public String distance;
}
