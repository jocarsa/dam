package com.jocarsa.mascontroles

import android.os.Bundle
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import androidx.activity.enableEdgeToEdge
import androidx.appcompat.app.AppCompatActivity
import androidx.core.view.ViewCompat
import androidx.core.view.WindowInsetsCompat

class MainActivity : AppCompatActivity() {
    override fun onCreate(savedInstanceState: Bundle?) {
        var listaMutable = mutableListOf<Pair<String,String>>()
        super.onCreate(savedInstanceState)
        enableEdgeToEdge()
        setContentView(R.layout.activity_main)
        ViewCompat.setOnApplyWindowInsetsListener(findViewById(R.id.main)) { v, insets ->
            val systemBars = insets.getInsets(WindowInsetsCompat.Type.systemBars())
            v.setPadding(systemBars.left, systemBars.top, systemBars.right, systemBars.bottom)
            insets
        }
        var miboton: Button = findViewById(R.id.miboton)
        var camponombre:EditText = findViewById(R.id.camponombre)
        var campoemail:EditText = findViewById(R.id.campoemail)



        miboton.setOnClickListener{

            Toast.makeText(this, camponombre.text, Toast.LENGTH_SHORT).show()
            Toast.makeText(this, campoemail.text, Toast.LENGTH_SHORT).show()
            // Meto los elementos en una lista mutbale
            listaMutable.add(Pair(camponombre.text.toString(),campoemail.text.toString()))
            Toast.makeText(this, "Ahora tengo "+listaMutable.size.toString()+" elementos", Toast.LENGTH_SHORT).show()
        }
    }
}