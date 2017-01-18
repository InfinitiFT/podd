package com.podd.activityTaxi;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.IntentSender;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.annotation.Nullable;
import android.support.v7.app.AppCompatActivity;
import android.view.View;
import android.widget.ImageView;
import android.widget.LinearLayout;
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
import com.podd.activityRestaurant.BestRestaurantNearCity;
import com.podd.location.LocationResult;
import com.podd.location.LocationTracker;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;


/**
 * The type Home screen activity.
 */
public class HomeScreenActivity extends AppCompatActivity implements View.OnClickListener, GoogleApiClient.ConnectionCallbacks, LocationResult {
    private Context context;
    private LinearLayout llTaxi;
    private LinearLayout llFood;
    private Intent intent;
    private final int REQUEST_LOCATION=123;
    private LocationManager locationManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home_screen);
        context=HomeScreenActivity.this;
        getIds();
        setListeners();

        LocationTracker locationTracker = new LocationTracker(context, this);
        locationManager = (LocationManager) context.getSystemService(Context.LOCATION_SERVICE);

    }

    private void setListeners() {
        llFood.setOnClickListener(this);
        llTaxi.setOnClickListener(this);

    }

    private void getIds() {
        TextView tvDiscoverLondon = (TextView) findViewById(R.id.tvDiscoverLondon);
        TextView tvServicedApartment = (TextView) findViewById(R.id.tvServicedApartment);
        TextView tvStayLondon = (TextView) findViewById(R.id.tvStayLondon);
        TextView tvFood = (TextView) findViewById(R.id.tvFood);
        TextView tvTaxi = (TextView) findViewById(R.id.tvTaxi);
        TextView tvHealth = (TextView) findViewById(R.id.tvHealth);
        TextView tvHappeningInLondon = (TextView) findViewById(R.id.tvHappeningInLondon);
        LinearLayout llHappening = (LinearLayout) findViewById(R.id.llHappening);
        LinearLayout llHealth = (LinearLayout) findViewById(R.id.llHealth);
        llTaxi= (LinearLayout) findViewById(R.id.llTaxi);
        llFood= (LinearLayout) findViewById(R.id.llfood);
        ImageView ivFood = (ImageView) findViewById(R.id.ivfood);
        ImageView ivTaxi = (ImageView) findViewById(R.id.ivTaxi);
        ImageView ivHealth = (ImageView) findViewById(R.id.ivHealth);
        ImageView ivHappeningInLondon = (ImageView) findViewById(R.id.ivHappeningInLondon);



    }

    @Override
    public void onClick(View view) {

        switch (view.getId()){
            case R.id.llfood:
                checkPermission();
                break;
            case R.id.llTaxi:
                intent =new Intent(context,MainHomeScreenThreeActivity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
                break;
        }

    }


    /*=============================================Location============================================*/
    private void checkPermission() {
        if (CommonUtils.checkPermissionGPS(HomeScreenActivity.this)) {

            if (!locationManager.isProviderEnabled(LocationManager.GPS_PROVIDER)) {
                enableLoc();

            } else {
                intent=new Intent(context, BestRestaurantNearCity.class);
                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(intent);
            }
        } else {
            CommonUtils.requestPermissionGPS(HomeScreenActivity.this);
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
                        intent=new Intent(context, BestRestaurantNearCity.class);
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
