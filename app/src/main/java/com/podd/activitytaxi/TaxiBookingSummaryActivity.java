package com.podd.activitytaxi;

import android.content.Context;
import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.EditText;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.podd.R;

public class TaxiBookingSummaryActivity extends AppCompatActivity implements View.OnClickListener {
    private Context context;
    private TextView tvCompleteBooking;
    private TextView tvBack;
    private TextView tvadditionalInfo;
    private TextView tvNumberofPeople;
    private TextView tvTime;
    private TextView tvDate;
    private TextView tvGoingTo;
    private TextView tvLeavingFrom;
    private TextView tvBookTaxi;
    private EditText etName;
    private EditText etCountryCode;
    private EditText etPhoneNumber;
    private final String EMAIL_PATTERN = "^[_A-Za-z0-9-]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$";
    private EditText etEmail;
    private LinearLayout llInner;

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
        tvadditionalInfo= (TextView) findViewById(R.id.tvadditionalInfo);
        tvNumberofPeople= (TextView) findViewById(R.id.tvNumberofPeople);
        tvTime= (TextView) findViewById(R.id.tvTime);
        tvDate= (TextView) findViewById(R.id.tvDate);
        tvGoingTo= (TextView) findViewById(R.id.tvGoingTo);
        tvLeavingFrom= (TextView) findViewById(R.id.tvLeavingFrom);
        tvBookTaxi= (TextView) findViewById(R.id.tvBookTaxi);
        etName= (EditText) findViewById(R.id.etName);
        etCountryCode= (EditText) findViewById(R.id.etCountryCode);
        etPhoneNumber= (EditText) findViewById(R.id.etPhoneNumber);
        etEmail= (EditText) findViewById(R.id.etEmail);
        llInner= (LinearLayout) findViewById(R.id.llInner);
        tvBack.setVisibility(View.VISIBLE);


    }

    private void setListeners() {
        tvCompleteBooking.setOnClickListener(this);
        tvBack.setOnClickListener(this);

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
        if(etName.getText().toString().trim().isEmpty()){
            Toast.makeText(context,R.string.please_enter_name,Toast.LENGTH_SHORT).show();
            etName.requestFocus();
            return false;
        }
        else if(etCountryCode.getText().toString().trim().isEmpty()){
            Toast.makeText(context,R.string.please_enter_country_code,Toast.LENGTH_SHORT).show();
            etCountryCode.requestFocus();
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
