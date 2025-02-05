<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>A-Frame Interactive Box Grid with Pointer Lock + Physics</title>
    
    <!-- A-Frame 1.6.0 -->
    <script src="https://aframe.io/releases/1.6.0/aframe.min.js"></script>
    
    <!-- A-Frame Physics System -->
    <script src="https://unpkg.com/aframe-physics-system-fork/dist/aframe-physics-system.min.js"></script>

    <style>
    @import url('https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap');

      body {
        margin: 0;
        overflow: hidden;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        font-family:Ubuntu;
      }
      #instruction {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 24px;
        text-align: center;
        z-index: 1;
        cursor: pointer;
      }
      #instruction.hidden {
        display: none;
      }
      #login{
      	position:absolute;
      	width:300px;
      	height:550px;
      	top:50%;
      	left:50%;
      	margin-top:-275px;
      	margin-left:-150px;
      	background:white;
      	padding:20px;
      	z-index:1000;
      	text-align:center;
      }
      #login img{
      	width:100%;
      }
      #login input,#login button{
      	width:100%;
      	box-sizing:border-box;
      	padding:10px;
      	margin-bottom:10px;
      }
      #guardar{
      	position:absolute;
      	right:20px;
      	top:20px;
      	padding:10px;
      	z-index:1000;
      }
    </style>
  </head>
  <body>
    <div id="instruction">Click to enter VR / Engage Pointer Lock</div>
    <div id="login">
    	<img src="sienna.png">
    	<h1>jocarsa | Sienna</h1>
    	<input type="text" id="usuario">
    	<input type="password" id="contrasena">
    	<button id="iniciarsesion">Iniciar sesión</button>
    </div>
    <script>
    	document.querySelector("#iniciarsesion").onclick = function(){
    		document.querySelector("#login").style.display = "none";
    		localStorage.setItem("siennausuario",document.querySelector("#usuario").value)
    	}
    </script>
	<button id="guardar">Guardar</button>
	<script>
		document.querySelector("#guardar").onclick = function(){
			console.log("vamos a guardar")
			const url = 'siennaback.php'; // Replace with your target URL
			const datos = {
				 usuario: localStorage.getItem("siennausuario"),
				 terreno: memoria
			};

			fetch(url, {
				 method: 'POST', // Use POST, PUT, DELETE, etc. as needed
				 headers: {
					  'Content-Type': 'application/json' // Set the content type to JSON
				 },
				 body: JSON.stringify(datos) // Convert the JavaScript object to a JSON string
			})
			.then(response => {
				 if (!response.ok) {
					  throw new Error(`HTTP error! Status: ${response.status}`);
				 }
				 return response.text(); // Parse JSON response if needed
			})
			.then(responseData => {
				 console.log('Response:', responseData);
			})
			.catch(error => {
				 console.error('Error:', error);
			});
		}
	</script>
    <!-- Enable shadows with "shadow" attribute and physics with "physics" -->
    <a-scene shadow="type: pcfsoft" physics="gravity: -9.8;">
      <a-assets>
        <!-- Define mixins for box materials -->
        <a-mixin
          id="material1"
          material="src: bloque.jpg; color: #ffcccc;"
        ></a-mixin>
        <a-mixin
          id="material2"
          material="src: bloque.jpg; color: #ccffcc;"
        ></a-mixin>
        <a-mixin
          id="material3"
          material="src: bloque.jpg; color: #ccccff;"
        ></a-mixin>
      </a-assets>

      <!-- Sky -->
      <a-sky color="#ECECEC"></a-sky>

      <!-- Directional "Sun" Light -->
      <!-- castShadow must be true to project shadows -->
      <a-entity
        light="type: directional; intensity: 1; castShadow: true"
        position="10 15 10"
      ></a-entity>

      <!-- Optional: Ambient light for a bit of global illumination -->
      <a-entity
        light="type: ambient; intensity: 0.3"
      ></a-entity>

      <!-- Player Rig -->
      <a-entity
        id="player"
        dynamic-body="mass: 5; shape: box;"
        position="0 1 0"
        wasd-controls
        look-controls
      >
        <!-- The camera -->
        <a-entity id="camera" camera>
          <a-cursor
            id="cursor"
            fuse="false"
            raycaster="objects: .clickable"
            material="color: black; shader: flat"
            geometry="primitive: ring; radiusInner: 0.005; radiusOuter: 0.01"
          ></a-cursor>
        </a-entity>
      </a-entity>
    </a-scene>

    <script>
      let memoria = [];

      // Prevent default context menu on right-click
      window.addEventListener("contextmenu", function (e) {
        e.preventDefault();
      }, false);

      const sceneEl = document.querySelector("a-scene");
      const instructionEl = document.getElementById("instruction");
      const playerEl = document.querySelector("#player");

      // Helper function to create a box
      function createBox(position, id, material) {
        const caja = document.createElement("a-box");
        caja.setAttribute("position", position);
        caja.setAttribute("rotation", "0 0 0");
        caja.setAttribute("mixin", "material" + material);
        caja.setAttribute("class", "clickable");
        caja.setAttribute("depth", "1");
        caja.setAttribute("height", "1");
        caja.setAttribute("width", "1");
        caja.setAttribute("identificador", id);

        // Boxes are static so the player can collide with them
        caja.setAttribute("static-body", "");

        // Enable casting and receiving shadows
        caja.setAttribute("shadow", "cast: true; receive: true");

        caja.addEventListener("click", function () {
          console.log("Left-clicked on:", caja);
          caja.parentNode.removeChild(caja);
          // Remove from memoria as well
          memoria.splice(id, 1);
          localStorage.setItem("memoria", JSON.stringify(memoria));
        });

        caja.addEventListener("contextmenu", function (event) {
          event.preventDefault();
          console.log("Right-clicked on:", caja);
          const currentPosition = caja.getAttribute("position");
          const newPosition = {
            x: currentPosition.x,
            y: currentPosition.y + 1,
            z: currentPosition.z,
          };
          createBox(
            `${newPosition.x} ${newPosition.y} ${newPosition.z}`,
            memoria.length, // new ID
            Math.ceil(Math.random() * 3)
          );
          // Also store the new box in memory & localStorage
          memoria.push({
            x: newPosition.x,
            y: newPosition.y,
            z: newPosition.z,
            mat: Math.ceil(Math.random() * 3),
          });
          localStorage.setItem("memoria", JSON.stringify(memoria));
        });

        sceneEl.appendChild(caja);
      }

      // Initialize memoria
      if (localStorage.getItem("memoria") == null) {
        console.log("No hay memoria previa, cargo una nueva");
        const gridSize = 5;
        for (let x = -gridSize; x <= gridSize; x++) {
          for (let z = -gridSize; z <= gridSize; z++) {
            for (let y = -5; y <= 0; y++) {
              memoria.push({
                x: x,
                y: y,
                z: z,
                mat: Math.ceil(Math.random() * 3),
              });
            }
          }
        }
      } else {
        console.log("Si que hay memoria previa, cargo la memoria existente");
        memoria = JSON.parse(localStorage.getItem("memoria"));
      }

      // Save the memory
      localStorage.setItem("memoria", JSON.stringify(memoria));

      // Re-create the boxes from memoria
      memoria.forEach(function (celda, index) {
        createBox(`${celda.x} ${celda.y} ${celda.z}`, index, celda.mat);
      });

      // === Pointer Lock & Instruction Overlay handling ===
      playerEl.addEventListener("click", function () {
        instructionEl.classList.add("hidden");
      });

      document.addEventListener("pointerlockchange", function () {
        if (
          document.pointerLockElement === sceneEl.canvas ||
          document.mozPointerLockElement === sceneEl.canvas ||
          document.webkitPointerLockElement === sceneEl.canvas
        ) {
          console.log("Pointer Lock Engaged");
          instructionEl.classList.add("hidden");
        } else {
          console.log("Pointer Lock Disengaged");
          instructionEl.classList.remove("hidden");
        }
      });

      document.addEventListener("pointerlockerror", function () {
        alert("Error attempting to enable pointer lock.");
        instructionEl.classList.remove("hidden");
      });

      instructionEl.addEventListener("click", function () {
        // Trigger a click on the camera rig to engage pointer lock via look-controls
        playerEl.emit("click");
      });
    </script>
  </body>
</html>

