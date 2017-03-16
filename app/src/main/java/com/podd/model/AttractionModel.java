package com.podd.model;

/**
 * Created by Raj Kumar on 3/9/2017
 * for Mobiloitte
 */

public class AttractionModel {
    public String getAttraction_name() {
        return attraction_name;
    }

    public void setAttraction_name(String attraction_name) {
        this.attraction_name = attraction_name;
    }

    public String getAttraction_category() {
        return attraction_category;
    }

    public void setAttraction_category(String attraction_category) {
        this.attraction_category = attraction_category;
    }

    public String getAttraction_location() {
        return attraction_location;
    }

    public void setAttraction_location(String attraction_location) {
        this.attraction_location = attraction_location;
    }

    public int getAttraction_image() {
        return attraction_image;
    }

    public void setAttraction_image(int attraction_image) {
        this.attraction_image = attraction_image;
    }

    public String attraction_name;
    public String attraction_category;
    public String attraction_location;
    public int attraction_image;

}
