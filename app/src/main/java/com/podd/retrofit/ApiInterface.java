package com.podd.retrofit;



import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;

import retrofit2.Call;
import retrofit2.http.Body;
import retrofit2.http.GET;
import retrofit2.http.Header;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Path;


/**
 * The interface Api interface.
 */
public interface ApiInterface {

    @POST("get_service_list.php")
    Call<JsonResponse>getServiceList();

    @POST("restaurant_list.php")
    Call<JsonResponse>getRestaurantsList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getCuisineRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getDietaryRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getMealRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getLocationRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_assest_list.php")
    Call<JsonResponse>getAmbienceRestaurantList(@Body JsonRequest jsonRequest);

    @POST("restaurant_details.php")
    Call<JsonResponse>getRestaurantDetails(@Body JsonRequest jsonRequest);

    @POST("time_interval.php")
    Call<JsonResponse>getRestaurantTimeInterval(@Body JsonRequest jsonRequest);

    @POST("restaurant_booking.php")
    Call<JsonResponse>sendOtp(@Body JsonRequest jsonRequest);


    @POST("otp_verification.php")
    Call<JsonResponse>otpVerification(@Body JsonRequest jsonRequest);

    @POST("resend_otp.php")
    Call<JsonResponse>resendOtp(@Body JsonRequest jsonRequest);


    @POST("search_restaurant.php")
    Call<JsonResponse>getSearchRestaurantApi(@Body JsonRequest jsonRequest);




}
