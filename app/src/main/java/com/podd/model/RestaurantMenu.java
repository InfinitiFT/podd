package com.podd.model;


import java.io.Serializable;
import java.util.List;

public class RestaurantMenu implements Serializable {
    public String rmd_id;
    public String meal_id;
    public String meal_name;
    public String deliver_food;
    public List<MealDetails> meal_details;


}
