package com.podd.retrofit;


import com.podd.model.CountryCodeModel;
import com.podd.model.HomeItemsModel;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import java.util.List;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.POST;
import retrofit2.http.Query;


/**
 * The interface Api interface.
 */
public interface ApiInterface {

    @POST("get_service_list.php")
    Call<JsonResponse>getServiceList(@Header("Authorization") String token);

    @GET("https://maps.googleapis.com/maps/api/geocode/json?")
    Call<JsonResponse>getPlaceApi(@Query("address") String request);

    @GET("https://restcountries.eu/rest/v1/all")
    Call<List<CountryCodeModel>>getCountryCodeApi();

    @POST("restaurant_list.php")
    Call<JsonResponse>getRestaurantsList(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getCuisineRestaurantList(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getDietaryRestaurantList(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getMealRestaurantList(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getLocationRestaurantList(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getAmbienceRestaurantList(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("restaurant_details.php")
    Call<JsonResponse>getRestaurantDetails(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("time_interval.php")
    Call<JsonResponse>getRestaurantTimeInterval(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("otp_verification.php")
    Call<JsonResponse>sendOtp(@Header("Authorization") String token,@Body JsonRequest jsonRequest);


    @POST("restaurant_booking.php")
    Call<JsonResponse>otpVerification(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("delivery_booking.php")
    Call<JsonResponse>deliveryBooking(@Header("Authorization") String token,@Body JsonRequest jsonRequest);

    @POST("resend_otp.php")
    Call<JsonResponse>resendOtp(@Header("Authorization") String token,@Body JsonRequest jsonRequest);


    @POST("search_restaurant.php")
    Call<JsonResponse>getSearchRestaurantApi(@Header("Authorization") String token,@Body JsonRequest jsonRequest);




}
