package com.jocarsa.persistencia

import android.content.SharedPreferences
import android.os.Bundle
import android.widget.Toast
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat

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
       var mispreferencias:SharedPreferences  = getSharedPreferences ("mispreferencias",MODE_PRIVATE)
        // Guardar un valor
        /*mispreferencias.edit().apply {
            putString("nombre","Jose Vicente")
            apply()
        }*/
        // Recuperar un valor
        /*
        var mivalor = mispreferencias.getString("nombre","por defecto")
        Toast.makeText(this,mivalor.toString(),Toast.LENGTH_SHORT).show()
        */

        // Borrar un valor
        /*mispreferencias.edit().apply {
            remove("nombre")
            apply()
        }*/
        // Eliminar todos los valores de la biblioteca
        mispreferencias.edit().apply {
            clear()
            apply()
        }
    }
}