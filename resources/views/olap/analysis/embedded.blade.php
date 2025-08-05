<div class="card mb-4">
    <div class="card-header bg-white">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#powerbi-tab">Power BI</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#grafana-tab">Grafana</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#custom-tab">Visualización Personalizada</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="powerbi-tab">
                <div class="ratio ratio-16x9">
                    <iframe src="{{ config('services.powerbi.embed_url') }}" 
                            frameborder="0" allowFullScreen="true"></iframe>
                </div>
            </div>
            <div class="tab-pane fade" id="grafana-tab">
                <div class="ratio ratio-16x9">
                    <iframe src="{{ config('services.grafana.embed_url') }}" 
                            frameborder="0"></iframe>
                </div>
            </div>
            <div class="tab-pane fade" id="custom-tab">
                <div id="customVizContainer">
                    <!-- Aquí iría la visualización personalizada con Chart.js, D3.js, etc. -->
                    <canvas id="customChart" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>