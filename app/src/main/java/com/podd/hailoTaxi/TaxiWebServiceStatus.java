package com.podd.hailoTaxi;

/**
 * Created by Raj Kumar on 2/28/2017
 * for Mobiloitte
 */

public abstract class TaxiWebServiceStatus {

    public abstract  void onSuccess(Object o);
    public abstract  void onFailed(int code);

}
