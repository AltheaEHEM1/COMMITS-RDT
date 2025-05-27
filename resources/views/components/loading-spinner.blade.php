<div class="loader-wrapper">
    <div class="loader"></div>
</div>

<style>
    .loader-wrapper {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50;
        }

        .loader {
            height: 15px;
            aspect-ratio: 4;
            --_g: no-repeat radial-gradient(farthest-side, #3b82f6 90%, #0000);
            background:
                var(--_g) left,
                var(--_g) right;
            background-size: 25% 100%;
            display: grid;
        }

        .loader:before,
        .loader:after {
            content: "";
            height: inherit;
            aspect-ratio: 1;
            grid-area: 1/1;
            margin: auto;
            border-radius: 50%;
            transform-origin: -100% 50%;
            background: #60a5fa;
            animation: l49 1s infinite linear;
        }

        .loader:after {
            transform-origin: 200% 50%;
            --s: -1;
            animation-delay: -.5s;
        }

        @keyframes l49 {

            58%,
            100% {
                transform: rotate(calc(var(--s, 1)*1turn))
            }
        }
</style>