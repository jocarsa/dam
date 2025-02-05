/*
	Archivo principal y general de código
	Gestiona las llamadas y el uso de Aframe.io en este proyecto
*/

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
