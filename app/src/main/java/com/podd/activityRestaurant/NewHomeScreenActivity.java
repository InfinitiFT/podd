package com.podd.activityRestaurant;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.IntentSender;
import android.content.pm.PackageManager;
import android.graphics.Typeface;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;
import android.os.CountDownTimer;
import android.os.Handler;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.LinearLayoutManager;
import android.support.v7.widget.RecyclerView;
import android.util.Log;

import android.view.animation.AlphaAnimation;
import android.view.animation.Animation;
import android.view.animation.LinearInterpolator;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.common.ConnectionResult;
import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;
import com.google.android.gms.location.LocationRequest;
import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.LocationSettingsRequest;
import com.google.android.gms.location.LocationSettingsResult;
import com.google.android.gms.location.LocationSettingsStatusCodes;
import com.podd.R;
import com.podd.adapter.HomeItemsAdapter;
import com.podd.adapter.HomePagerAdapter;
import com.podd.location.LocationResult;
import com.podd.location.LocationTracker;
import com.podd.model.HomeImageModel;
import com.podd.model.HomeItemsModel;
import com.podd.retrofit.ApiClient;
import com.podd.retrofit.ApiInterface;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.webservices.JsonResponse;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Timer;
import java.util.TimerTask;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

@SuppressWarnings("ALL")
public class NewHomeScreenActivity extends AppCompatActivity implements GoogleApiClient.ConnectionCallbacks, LocationResult {
    private TextView tvAdminMessage,tvAppName;
    private RecyclerView rvHomeItems;
    private HomeItemsAdapter homeItemsAdapter;
    private Context context;
    private List<HomeItemsModel> homeItemsModelList = new ArrayList<>();
    private List<HomeImageModel> homeImageModels = new ArrayList<>();
    private int REQUEST_LOCATION=123;
    private LocationManager locationManager;
    private HomePagerAdapter pagerAdapter;
    private ViewPager viewPager;
    private ArrayList<String> banner_image;
    private TextView tvTime,tvDayDate,tvWelcome;
//    private  int[] img = new int[]{R.mipmap.image2, R.mipmap.image3, R.mipmap.image4, R.mipmap.image1};
    private  String[] itemName = new String[]{"Restaurants & Bars","Delivery","Taxi","Airport Transfers","Attractions","Fitness & Wellbeing","Info"};
   // private List<Integer> imgList;
    int currentPage = 0;
    Timer timer;
    final long DELAY_MS = 500;//delay in milliseconds before task is to be executed
    final long PERIOD_MS = 3000; // time in milliseconds between successive task executions.

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_new_home_screen);
        context=NewHomeScreenActivity.this;
        getIds();
        setRecycler();
        setFont();
        for (int i = 0; i < itemName.length; i++) {
            HomeItemsModel hotelItemModel = new HomeItemsModel();
            hotelItemModel.setService_name(itemName[i]);
            homeItemsModelList.add(hotelItemModel);
        }
       // banner_image = new ArrayList<>();
        viewPager = (ViewPager) findViewById(R.id.viewpager);

       // viewPager.startAutoScroll(4000);
        //setRecyclerData();

        /*After setting the adapter use the timer */
        final Handler handler = new Handler();
        final Runnable Update = new Runnable() {
            public void run() {
                if (currentPage == homeImageModels.size()-1) {
                    currentPage = 0;
                }
                viewPager.setCurrentItem(currentPage++, true);
            }
        };

        timer = new Timer(); // This will create a new Thread
        timer .schedule(new TimerTask() { // task to be scheduled

            @Override
            public void run() {
                handler.post(Update);
            }
        },500, 3000);
      //  ImageView ivLogo=(ImageView)findViewById(R.id.ivLogo);
        try {
            Animation  animation = new AlphaAnimation(1, 0); // Change alpha from fully visible to invisible
            animation.setDuration(3000); // duration - half a second
            animation.setInterpolator(new LinearInterpolator()); // do not alter animation rate
            animation.setRepeatCount(3000); // Repeat animation infinitely
            animation.setRepeatMode(3000);
            viewPager.startAnimation(animation);

        }catch (Exception e2)
        {
            e2.printStackTrace();
        }

        /*if(CommonUtils.isNetworkConnected(this)){
            callHomeApi();
        }else {
            Toast.makeText(context, R.string.Please_connect_to_internet_first, Toast.LENGTH_SHORT).show();
        }*/

        LocationTracker locationTracker = new LocationTracker(context, this);
        locationManager = (LocationManager) context.getSystemService(Context.LOCATION_SERVICE);
        checkPermission();

    }

    private void setFont() {
       Typeface typeface = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Regular.ttf");
        tvDayDate.setTypeface(typeface);

        Typeface typefaceBold = Typeface.createFromAsset(getAssets(), "fonts/Roboto-Bold.ttf");
        tvTime.setTypeface(typefaceBold);
        tvAdminMessage.setTypeface(typefaceBold);
       // tvWelcome.setTypeface(typefaceBold);
       // tvAppName.setTypeface(typefaceBold);
    }

    private void callHomeApi() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        Call<JsonResponse> call = apiServices.getServiceList(CommonUtils.getPreferences(this,AppConstant.AppToken));
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        homeItemsModelList.clear();
                        if (response.body().allServiceList != null && response.body().allServiceList.size() > 0) {
                            homeItemsModelList.addAll(response.body().allServiceList);
                            homeItemsAdapter.notifyDataSetChanged();
                        } else {
                            Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                        }
                    } else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                }
                else {
                    Toast.makeText(context, R.string.server_not_responding, Toast.LENGTH_SHORT).show();
                }
            }
            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                t.printStackTrace();
            }
        });
    }
    private void callHomeImageAPI() {
        CommonUtils.showProgressDialog(context);
        ApiInterface apiServices = ApiClient.getClient(this).create(ApiInterface.class);
        Call<JsonResponse> call = apiServices.getHomeImage(CommonUtils.getPreferences(this,AppConstant.AppToken));
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null) {

                    if (response.body().responseCode.equalsIgnoreCase("200")) {
                        homeImageModels.clear();
                        if (response.body().homePageData != null && response.body().homePageData.size() > 0) {
                            homeImageModels.addAll(response.body().homePageData);
                            pagerAdapter = new HomePagerAdapter(context, homeImageModels);
                            viewPager.setAdapter(pagerAdapter);

                        } else {
                            Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                        }
                    } else {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }
                }
                else {
                    Toast.makeText(context, R.string.server_not_responding, Toast.LENGTH_SHORT).show();
                }
            }
            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                t.printStackTrace();
            }
        });
    }
    private void setRecycler() {
        homeItemsAdapter = new HomeItemsAdapter(context,homeItemsModelList);
        RecyclerView.LayoutManager mLayoutManager = new LinearLayoutManager(context,LinearLayoutManager.HORIZONTAL,false);
        rvHomeItems.setLayoutManager(mLayoutManager);
        rvHomeItems.setAdapter(homeItemsAdapter);
    }
    private void getIds() {
        ImageView ivRestaurantImage = (ImageView) findViewById(R.id.ivRestaurantImage);
        rvHomeItems= (RecyclerView) findViewById(R.id.rvHomeItems);
        tvTime = (TextView) findViewById(R.id.tvTime);
        tvDayDate = (TextView) findViewById(R.id.tvDayDate);
       // tvWelcome = (TextView) findViewById(R.id.tvWelcome);
        tvAdminMessage = (TextView) findViewById(R.id.tvAdminMessage);
     //   tvAppName = (TextView) findViewById(R.id.tvAppName);
        tvDayDate.setText(CommonUtils.getDateAndTimeFromTimeStamp(System.currentTimeMillis()));
       // tvTime.setText(CommonUtils.getTimeFromTimeStamp(System.currentTimeMillis()));
        /*Calendar calander = Calendar.getInstance();
        SimpleDateFormat simpledateformat = new SimpleDateFormat("HH:mm");
        String date = simpledateformat.format(calander.getTime());
        tvTime.setText(date);*/

     /*   imgList = new ArrayList<>();
        imgList.add(R.mipmap.image1);
        imgList.add(R.mipmap.image2);
        imgList.add(R.mipmap.image3);
        imgList.add(R.mipmap.image4);
        imgList.add(R.mipmap.image3);*/

        CountDownTimer newtimer = new CountDownTimer(1000000000, 1000) {

            public void onTick(long millisUntilFinished) {
                Calendar c = Calendar.getInstance();
                Date now = new Date();
                SimpleDateFormat sdf = new SimpleDateFormat("HH:mm ");
                String formattedTime = sdf.format(now);
             //   tvTime.setText(c.get(Calendar.HOUR_OF_DAY)+":"+c.get(Calendar.MINUTE));
                tvTime.setText(formattedTime);
            }
            public void onFinish() {

            }
        };
        newtimer.start();



    }

    /*=============================================Location============================================*/
    private void checkPermission() {
        if (CommonUtils.checkPermissionGPS(NewHomeScreenActivity.this)) {

            if (!locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                enableLoc();

            } else {
                Log.e("logEnabled","Location already enabled");
            }
        } else {
            CommonUtils.requestPermissionGPS(NewHomeScreenActivity.this);
        }
    }

    private void enableLoc() {

        GoogleApiClient googleApiClient = new GoogleApiClient.Builder(this)
                .addApi(LocationServices.API)
                .addConnectionCallbacks(this)
                .addOnConnectionFailedListener(new GoogleApiClient.OnConnectionFailedListener() {
                    @Override
                    public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {

                    }
                }).build();
        googleApiClient.connect();

        LocationRequest locationRequest = LocationRequest.create();
        locationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);
        locationRequest.setInterval(30 * 1000);
        locationRequest.setFastestInterval(5 * 1000);
        LocationSettingsRequest.Builder builder = new LocationSettingsRequest.Builder()
                .addLocationRequest(locationRequest);
        builder.setAlwaysShow(true);


        PendingResult<LocationSettingsResult> result =
                LocationServices.SettingsApi.checkLocationSettings(googleApiClient, builder.build());
        result.setResultCallback(new ResultCallback<LocationSettingsResult>() {
            @Override
            public void onResult(LocationSettingsResult result) {
                final Status status = result.getStatus();
                switch (status.getStatusCode()) {


                    case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
                        try {
                            // Show the dialog by calling startResolutionForResult(),
                            // and check the result in onActivityResult().
                            status.startResolutionForResult(
                                    (Activity) context, REQUEST_LOCATION);

                        } catch (IntentSender.SendIntentException e) {
                            // Ignore the error.
                        }
                        break;
                }
            }
        });
    }


    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String permissions[], @NonNull int[] grantResults) {
        switch (requestCode) {

            case AppConstant.PERMISSION_REQUEST_GPS_CODE:
                if (grantResults.length > 0 && grantResults[0] == PackageManager.PERMISSION_GRANTED) {

                    if (!locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                        enableLoc();
                    } else {
                        Intent intent = new Intent(context, BestRestaurantNearCity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        startActivity(intent);
                    }
                } else {
                    Toast.makeText(getApplicationContext(), R.string.permission_denied_you_can_not_access_location_data, Toast.LENGTH_LONG).show();

                }
                break;

        }
    }

    @Override
    public void onConnected(@Nullable Bundle bundle) {

    }

    @Override
    public void onConnectionSuspended(int i) {

    }

    @Override
    public void gotLocation(Location location) {

    }
}
