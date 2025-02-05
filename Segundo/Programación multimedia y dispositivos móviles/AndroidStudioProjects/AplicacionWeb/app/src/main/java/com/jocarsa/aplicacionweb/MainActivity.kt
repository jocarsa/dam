package com.jocarsa.aplicacionweb

import android.os.Bundle
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat
import android.webkit.WebView


class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        val mivista:WebView = findViewById(R.id.mivistaweb)     // Selecciono la vista web del documento XML
        mivista.settings.javaScriptEnabled = true               // Activo Javascript dado que el origen es de confianza
        mivista.loadUrl("file:///android_asset/index.html")
        //mivista.loadUrl("https://jocarsa.com")
    }
}