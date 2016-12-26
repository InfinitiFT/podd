package com.podd.activityrestauarant;

import android.app.Activity;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;
import com.podd.utils.AppConstant;
import com.podd.utils.CommonUtils;
import com.podd.utils.DialogUtils;

/**
 * The type Booking summary activity.
 */
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

                    dialogConfirmBooking = DialogUtils.createCustomDialog(context, R.layout.dialog_booking_confirmation);
                    TextView tvSubmit = (TextView) dialogConfirmBooking.findViewById(R.id.tvSubmit);
                    etEnterOtp = (EditText) dialogConfirmBooking.findViewById(R.id.etEnterOtp);


                    tvSubmit.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {

                            if(isValidOtp()) {
                                dialogConfirmBooking.dismiss();
                                intent = new Intent(context, RestaurantReturnToHomeActivity.class);
                                intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                startActivity(intent);
                            }
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
}
