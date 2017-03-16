package com.podd.hailoTaxi;

import android.app.Dialog;
import android.content.Context;
import android.os.AsyncTask;

import com.podd.utils.CommonUtils;

/**
 * Created by Raj Kumar on 2/28/2017
 * for Mobiloitte
 */

public class TaxiServiceAsync extends AsyncTask {
    private String request;
    private TaxiWebServiceStatus serviceStatus;
    private String url, methodName;
    private Context context;
    private Dialog progressDialog;
    private boolean showProgress = true;
    private String token = "", headerType = "", tokenName = "";
    private ServiceCall serviceCall;

    public TaxiServiceAsync(Context context, String request, String url, String methodName,
                            boolean showProgress, String token, String headerType, String tokenName,
                            TaxiWebServiceStatus serviceStatus) {
        this.request = request;
        this.serviceStatus = serviceStatus;
        this.url = url;
        this.methodName = methodName;
        this.context = context;
        this.showProgress = showProgress;
        this.token = token;
        this.headerType = headerType;
        this.tokenName = tokenName;
    }

    @Override
    protected void onPreExecute() {
        super.onPreExecute();
        try {
            if (showProgress) {
                CommonUtils.showProgressDialog(context);
                progressDialog.show();
            }
        } catch (Exception ignored) {
        }
    }

    @Override
    protected Object doInBackground(Object[] params) {

        serviceCall = new ServiceCall();
        String response = serviceCall.getServiceResponse(url, request, methodName, headerType, tokenName, token);
        try {
            if (response != null) {
                return response;
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        return null;
    }

    @Override
    protected void onPostExecute(Object o) {
        super.onPostExecute(o);
        try {
            CommonUtils.disMissProgressDialog(context);
            if (progressDialog != null) {
                progressDialog.dismiss();
            }
        } catch (Exception e) {
            e.printStackTrace();
        }
        if (o != null) {
            serviceStatus.onSuccess(o);
        } else {
            serviceStatus.onFailed(serviceCall.getStatusCode());
        }
    }
}
