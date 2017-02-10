package com.podd.webservices;


import com.podd.model.OrderDetail;
import com.podd.model.SavedItem;

import java.io.Serializable;
import java.util.List;

public class JsonRequest implements Serializable {
 public  String   type;
 public  String   search_content;
 public String latitude;
 public String longitude;
 public String page_size;
 public int page_number;
 public String restaurant_id;
 public String booking_date;
 public String booking_time;
 public String number_of_people;
 public String name;
 public String email;
 public String contact_no;
 public String deliver_food;

 public String cusine;
 public String dietary;
 public String ambience;
 public String location;
 public String meal;
 public String otp;
 public String date;
 public String total_price;
 public String address;
 public List<SavedItem> order_details;


}
