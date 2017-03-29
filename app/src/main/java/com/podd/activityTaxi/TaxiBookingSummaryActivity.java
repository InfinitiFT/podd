package com.podd.activityTaxi;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;

/**
 * The type Taxi booking summary activity.
 */
public class TaxiBookingSummaryActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private TextView tvCompleteBooking;
    private TextView tvBack;
    private EditText etName;
    private TextView tvCountryCode;
    private EditText etPhoneNumber;
    private EditText etEmail;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_taxi_booking_summary);
        context=TaxiBookingSummaryActivity.this;
        getIds();
        setListeners();
    }

    private void getIds() {
        tvCompleteBooking= (TextView) findViewById(R.id.tvCompleteBooking);
        TextView tvadditionalInfo = (TextView) findViewById(R.id.tvadditionalInfo);
        TextView tvNumberofPeople = (TextView) findViewById(R.id.tvNumberofPeople);
        TextView tvTime = (TextView) findViewById(R.id.tvTime);
        TextView tvDate = (TextView) findViewById(R.id.tvDate);
        TextView tvGoingTo = (TextView) findViewById(R.id.tvGoingTo);
        TextView tvLeavingFrom = (TextView) findViewById(R.id.tvLeavingFrom);
        TextView tvBookTaxi = (TextView) findViewById(R.id.tvBookTaxi);
        etName= (EditText) findViewById(R.id.etName);
        tvCountryCode= (TextView) findViewById(R.id.tvCountryCode);
        etPhoneNumber= (EditText) findViewById(R.id.etPhoneNumber);
        etEmail= (EditText) findViewById(R.id.etEmail);
        LinearLayout llInner = (LinearLayout) findViewById(R.id.llInner);


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
        switch (view.getId()){
            case R.id.tvCompleteBooking:
                if(isValid()) {
                    Intent intent = new Intent(context, TaxiReturnToHomeScreen.class);
                    intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                    startActivity(intent);
                }
                break;
        }

    }

    private boolean isValid(){
        String EMAIL_PATTERN = "^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";
        if(etName.getText().toString().trim().isEmpty()){
            Toast.makeText(context,R.string.please_enter_name,Toast.LENGTH_SHORT).show();
            etName.requestFocus();
            return false;
        }
        else if(tvCountryCode.getText().toString().trim().isEmpty()){
            Toast.makeText(context,R.string.please_enter_country_code,Toast.LENGTH_SHORT).show();
            tvCountryCode.requestFocus();
            return false;
        }
        else if (etPhoneNumber.getText().toString().trim().isEmpty()){
            Toast.makeText(context,R.string.please_enter_phone_number,Toast.LENGTH_SHORT).show();
            etPhoneNumber.requestFocus();
            return false;
        }
        else if (etEmail.getText().toString().trim().isEmpty()){
            Toast.makeText(context,R.string.please_enter_email,Toast.LENGTH_SHORT).show();
            etEmail.requestFocus();
            return false;
        }
        else if (!etEmail.getText().toString().trim().matches(EMAIL_PATTERN)){
            Toast.makeText(context,R.string.please_enter_valid_email,Toast.LENGTH_SHORT).show();
            etEmail.requestFocus();
            return false;
        }
        return true;
    }
}