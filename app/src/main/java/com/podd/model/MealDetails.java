package com.podd.model;

import java.io.Serializable;
import java.util.List;


public class MealDetails implements Serializable{


    public String subtitle_id;
    public String subtitle_name;
    public List<SubItemMealDetails> subtitle_meal_details;
}
