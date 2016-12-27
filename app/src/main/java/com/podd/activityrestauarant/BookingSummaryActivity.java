package com.podd.activityrestauarant;


import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;
import com.google.gson.Gson;
import com.podd.R;
import com.podd.retrofit.ApiClient;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.DialogUtils;
import com.podd.webservices.JsonRequest;
import com.podd.webservices.JsonResponse;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;


public class BookingSummaryActivity extends AppCompatActivity implements View.OnClickListener {
    private Intent intent;
    private Context context;
    private EditText etName;
    private TextView tvCountryCode;
    private EditText etPhoneNumber;
    private final String EMAIL_PATTERN = "^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";
    private EditText etEmail;
    private TextView tvCompleteBooking;
    private TextView tvBookingSummary;
    private TextView tvRestaurantName;
    private TextView tvLocation;
    private TextView tvDateBooked;
    private TextView tvTimeBooked;
    private TextView tvNumberofPeople;
    private TextView tvConfirmation;
    private Dialog dialogConfirmBooking;
    private EditText etEnterOtp;
    private String location;
    private String dateBooked;
    private String timeBooked;
    private String noOfPersons;
    private String restaurantName;
    private String restaurantId;
    private String TAG=BookingSummaryActivity.class.getSimpleName();
    private String name;
    private String email;
    private String phone;
    private String otp;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_booking_summary);
        context = BookingSummaryActivity.this;
        getIds();
        setListeners();
        restaurantName=getIntent().getStringExtra(AppConstant.RESTAURANTNAME);
        location=getIntent().getStringExtra(AppConstant.LOCATION);
        dateBooked=getIntent().getStringExtra(AppConstant.DATEBOOKED);
        timeBooked=getIntent().getStringExtra(AppConstant.TIMEBOOKED);
        noOfPersons=getIntent().getStringExtra(AppConstant.NOOFPEOPLE);
        restaurantId=getIntent().getStringExtra(AppConstant.RESTAURANTID);

        tvRestaurantName.setText(restaurantName);
        tvLocation.setText(location);
        tvDateBooked.setText(dateBooked);
        tvTimeBooked.setText(timeBooked);
        tvNumberofPeople.setText(noOfPersons);






    }

    private void getIds() {
        tvCompleteBooking = (TextView) findViewById(R.id.tvCompleteBooking);
        etName = (EditText) findViewById(R.id.etName);
        tvCountryCode = (TextView) findViewById(R.id.tvCountryCode);
        etPhoneNumber = (EditText) findViewById(R.id.etPhoneNumber);
        etEmail = (EditText) findViewById(R.id.etEmail);
        tvBookingSummary = (TextView) findViewById(R.id.tvBookingSummary);
        tvRestaurantName = (TextView) findViewById(R.id.tvRestaurantName);
        tvLocation = (TextView) findViewById(R.id.tvLocation);
        tvDateBooked = (TextView) findViewById(R.id.tvDateBooked);
        tvTimeBooked = (TextView) findViewById(R.id.tvTimeBooked);
        tvNumberofPeople = (TextView) findViewById(R.id.tvNumberofPeople);
        tvConfirmation = (TextView) findViewById(R.id.tvConfirmation);


        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        if (getSupportActionBar() != null) {
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            getSupportActionBar().setDisplayShowHomeEnabled(true);
            getSupportActionBar().setTitle("");
        }
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                onBackPressed();
            }
        });

    }

    private void setListeners() {
        tvCompleteBooking.setOnClickListener(this);
    }

    @Override
    public void onClick(View view) {
        switch (view.getId()) {
            case R.id.tvCompleteBooking:
                if (isValid()) {
                    name=etName.getText().toString().trim();
                    phone=etPhoneNumber.getText().toString().trim();
                    email=etEmail.getText().toString().trim();
                    sendOtpApi();

                    dialogConfirmBooking = DialogUtils.createCustomDialog(context, R.layout.dialog_booking_confirmation);
                    TextView tvSubmit = (TextView) dialogConfirmBooking.findViewById(R.id.tvSubmit);
                    TextView tvResendOtp = (TextView) dialogConfirmBooking.findViewById(R.id.tvResendOtp);
                    etEnterOtp = (EditText) dialogConfirmBooking.findViewById(R.id.etEnterOtp);


                    tvSubmit.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {

                            if(isValidOtp()) {
                                otp=etEnterOtp.getText().toString().trim();
                                otpVerificationApi();

                            }
                        }
                    });

                    tvResendOtp.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            resendOtpService();

                        }
                    });

                    dialogConfirmBooking.show();
                    break;
                }
                break;

        }
    }

    private boolean isValidOtp() {
        if (etEnterOtp.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_otp, Toast.LENGTH_SHORT).show();
            return false;
        } else if (etEnterOtp.getText().toString().trim().length() <= 3) {
            Toast.makeText(context, R.string.please_enter_valid_otp, Toast.LENGTH_SHORT).show();
            return false;
        }
        return true;
    }


    private boolean isValid() {
        if (etName.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_name, Toast.LENGTH_SHORT).show();
            etName.requestFocus();
            return false;
        } else if (etPhoneNumber.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_phone_number, Toast.LENGTH_SHORT).show();
            etPhoneNumber.requestFocus();
            return false;
        } else if (etEmail.getText().toString().trim().isEmpty()) {
            Toast.makeText(context, R.string.please_enter_email, Toast.LENGTH_SHORT).show();
            etEmail.requestFocus();
            return false;
        } else if (!etEmail.getText().toString().trim().matches(EMAIL_PATTERN)) {
            Toast.makeText(context, R.string.please_enter_valid_email, Toast.LENGTH_SHORT).show();
            etEmail.requestFocus();
            return false;
        }
        return true;
    }



    private void sendOtpApi() {
        CommonUtils.showProgressDialog(context);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.restaurant_id=restaurantId;
        jsonRequest.booking_date=dateBooked;
        jsonRequest.booking_time=timeBooked;
        jsonRequest.number_of_people=noOfPersons;
        jsonRequest.name=name;
        jsonRequest.email=email;
        jsonRequest.contact_no=phone;


        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = ApiClient.getApiService().sendOtp(jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();



                    } else if(response.body().responseCode.equalsIgnoreCase("400"))
                    {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }

                } else {
                    Toast.makeText(context, R.string.server_not_responding, Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                Log.e(TAG, t.toString());

            }
        });

    }


    private void otpVerificationApi() {
        CommonUtils.showProgressDialog(context);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.contact_no=phone;
        jsonRequest.otp=otp;


        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = ApiClient.getApiService().otpVerification(jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                        dialogConfirmBooking.dismiss();

                        intent = new Intent(context, RestaurantReturnToHomeActivity.class);
                        intent.putExtra(AppConstant.RESTAURANTID,restaurantId);
                        intent.putExtra(AppConstant.RESTAURANTNAME,restaurantName);
                        intent.putExtra(AppConstant.LOCATION,location);
                        intent.putExtra(AppConstant.DATEBOOKED,dateBooked);
                        intent.putExtra(AppConstant.TIMEBOOKED,timeBooked);
                        intent.putExtra(AppConstant.NOOFPEOPLE,noOfPersons);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        startActivity(intent);


                    } else if(response.body().responseCode.equalsIgnoreCase("400"))
                    {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                    }

                } else {
                    Toast.makeText(context, R.string.server_not_responding, Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                Log.e(TAG, t.toString());

            }
        });

    }


    private void resendOtpService() {
        CommonUtils.showProgressDialog(context);
        final JsonRequest jsonRequest = new JsonRequest();
        jsonRequest.contact_no=phone;

        Log.e(TAG, "" + new Gson().toJsonTree(jsonRequest).toString().trim());
        Call<JsonResponse> call = ApiClient.getApiService().resendOtp(jsonRequest);
        call.enqueue(new Callback<JsonResponse>() {
            @Override
            public void onResponse(Call<JsonResponse> call, Response<JsonResponse> response) {
                CommonUtils.disMissProgressDialog(context);
                if (response.body() != null && !response.body().toString().equalsIgnoreCase("")) {
                    Log.e(TAG, "" + new Gson().toJsonTree(response.body().toString().trim()));
                    if (response.body().responseCode.equalsIgnoreCase("200")) {

                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();

                    } else if(response.body().responseCode.equalsIgnoreCase("400"))
                    {
                        Toast.makeText(context, response.body().responseMessage, Toast.LENGTH_SHORT).show();
                        sendOtpApi();
                        /*intent =new Intent(context,BookingSummaryActivity.class);
                        intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                        startActivity(intent);*/

                    }

                } else {
                    Toast.makeText(context, R.string.server_not_responding, Toast.LENGTH_SHORT).show();
                }
            }

            @Override
            public void onFailure(Call<JsonResponse> call, Throwable t) {
                CommonUtils.disMissProgressDialog(context);
                Log.e(TAG, t.toString());

            }
        });

    }




}
