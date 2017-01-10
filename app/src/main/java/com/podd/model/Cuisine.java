package com.podd.model;

import java.io.Serializable;


public class Cuisine implements Serializable{


    public String id;
    public String name;
    public String cuisine_name;
    public String created_on;

    @Override
    public String toString() {
        return name;
    }
}
