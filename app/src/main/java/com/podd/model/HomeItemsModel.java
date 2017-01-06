package com.podd.model;


public class HomeItemsModel {

    public String id;
    public String service_name;
    public String service_image;


    public int getItemImage() {
        return ItemImage;
    }

    public void setItemImage(int itemImage) {
        ItemImage = itemImage;
    }

    public String getItemName() {
        return ItemName;
    }

    public void setItemName(String itemName) {
        ItemName = itemName;
    }

    private int ItemImage;
    private String ItemName;

}
