package com.podd.location;



import android.Manifest;
import android.app.Activity;
import android.content.Context;
import android.content.IntentSender;
import android.content.pm.PackageManager;
import android.location.Location;

import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.content.ContextCompat;

import com.google.android.gms.common.ConnectionResult;

import com.google.android.gms.common.api.GoogleApiClient;
import com.google.android.gms.common.api.PendingResult;
import com.google.android.gms.common.api.ResultCallback;
import com.google.android.gms.common.api.Status;

import com.google.android.gms.location.LocationListener;
import com.google.android.gms.location.LocationRequest;

import com.google.android.gms.location.LocationServices;
import com.google.android.gms.location.LocationSettingsRequest;
import com.google.android.gms.location.LocationSettingsResult;
import com.google.android.gms.location.LocationSettingsStatusCodes;


/** This class is used for Getting location form GPS */

public class LocationTracker implements LocationListener, GoogleApiClient.ConnectionCallbacks, GoogleApiClient.OnConnectionFailedListener, ResultCallback<LocationSettingsResult> {


	private LocationRequest mLocationRequest;
	private GoogleApiClient mLocationClient;
	private final Context context;
	private final LocationResult locationResult;
	public static final int REQUEST_CHECK_SETTINGS = 100;

	public LocationTracker(Context context, LocationResult locationResult) {
		super();
		this.context = context;
		this.locationResult = locationResult;
	}


	public void onUpdateLocation() {
		mLocationRequest = new LocationRequest();
		mLocationRequest.setSmallestDisplacement(100.0f);
        mLocationRequest.setInterval(1000);
        mLocationRequest.setFastestInterval(5000);
		mLocationRequest.setPriority(LocationRequest.PRIORITY_HIGH_ACCURACY);

		mLocationClient = new GoogleApiClient.Builder(context, LocationTracker.this, LocationTracker.this)
				.addConnectionCallbacks(this)
				.addOnConnectionFailedListener(this)
				.addApi(LocationServices.API)
				.build();

		if (mLocationClient.isConnected()) {
			startUpdates();
		} else {
			mLocationClient.connect();
		}
	}



	@Override
	public void onConnected(Bundle connectionHint) {
		LocationSettingsRequest.Builder builder = new LocationSettingsRequest.Builder()
				.addLocationRequest(mLocationRequest);
		builder.setAlwaysShow(true);
		PendingResult<LocationSettingsResult> result =
				LocationServices.SettingsApi.checkLocationSettings(
						mLocationClient,
						builder.build()
				);

		result.setResultCallback(this);
		startUpdates();
	}

	@Override
	public void onConnectionSuspended(int i) {

	}

	@Override
	public void onLocationChanged(Location location) {
		if (location != null) {

			if (location.getLatitude() != 0 && location.getLongitude() != 0) {
                    locationResult.gotLocation(location);
				if (mLocationClient != null && mLocationClient.isConnected()) {
					stopPeriodicUpdates();
				}

			}
		}

	}



	/**
	 * In response to a request to start updates, send a request
	 * to Location Services
	 */
	private void startPeriodicUpdates() {
		if(checkPermission())
			LocationServices.FusedLocationApi.requestLocationUpdates(mLocationClient, mLocationRequest, LocationTracker.this);

	}

	/**
	 * In response to a request to stop updates, send a request to
	 * Location Services
	 */
	private void stopPeriodicUpdates() {
		if(checkPermission())
			LocationServices.FusedLocationApi.removeLocationUpdates(mLocationClient,LocationTracker.this);
	}



	private void startUpdates() {
		startPeriodicUpdates();

	}




	private boolean checkPermission(){
		int result = ContextCompat.checkSelfPermission(context, Manifest.permission.ACCESS_FINE_LOCATION);
		return result == PackageManager.PERMISSION_GRANTED;
	}


	@Override
	public void onResult(@NonNull LocationSettingsResult locationSettingsResult) {
		final Status status = locationSettingsResult.getStatus();
		switch (status.getStatusCode()) {
			case LocationSettingsStatusCodes.SUCCESS:

				// NO need to show the dialog;
				break;

			case LocationSettingsStatusCodes.RESOLUTION_REQUIRED:
				//  Location settings are not satisfied. Show the user a dialog

				try {
					// Show the dialog by calling startResolutionForResult(), and check the result
					// in onActivityResult().

					status.startResolutionForResult((Activity) context, REQUEST_CHECK_SETTINGS);

				} catch (IntentSender.SendIntentException e) {

					//failed to show
				}
				break;

			case LocationSettingsStatusCodes.SETTINGS_CHANGE_UNAVAILABLE:
				// Location settings are unavailable so not possible to show any dialog now
				break;
		}
	}

	@Override
	public void onConnectionFailed(@NonNull ConnectionResult connectionResult) {

	}
}
