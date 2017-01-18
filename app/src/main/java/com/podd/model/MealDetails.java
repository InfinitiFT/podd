package com.podd.model;

import java.io.Serializable;
import java.util.List;

/**
 * Created by Shalini Bishnoi on 17-01-2017.
 */
public class MealDetails implements Serializable{


    public String subtitle_id;
    public String subtitle_name;
    public List<SubItemMealDetails> subtitle_meal_details;
}
