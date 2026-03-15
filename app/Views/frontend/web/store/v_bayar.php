<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-4">
    <div class="container">
        <h1 class="mb-4 fw-bold">Shopping Cart</h1>
        
        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
            <div class="fw-medium text-secondary">1 Course in Cart</div>
        </div>
        
        <div class="bg-white rounded-3 shadow-sm mb-4">
            <div class="d-flex flex-wrap flex-md-nowrap p-4 border-bottom">
                <div class="flex-shrink-0 me-4 mb-3 mb-md-0">
                    <div class="bg-secondary rounded-2" style="width:120px;height:120px;display:flex;align-items:center;justify-content:center;color:white;font-weight:bold">
                        Course
                    </div>
                </div>
                
                <div class="flex-grow-1">
                    <h2 class="h5 fw-bold mb-2">AI Engineer Agentic Track: The Complete Agent & MCP Course</h2>
                    <p class="text-secondary mb-2">By Ed Donner and 1 other</p>
                    
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        <span class="badge bg-success-subtle text-success border border-success">Bestseller</span>
                        <span class="badge bg-secondary-subtle text-secondary border">Premium</span>
                    </div>
                    
                    <div class="text-secondary d-flex flex-wrap gap-3 small mb-3">
                        <span>17 total hours</span>
                        <span>130 lectures</span>
                        <span>Intermediate</span>
                    </div>
                    
                    <div class="d-flex flex-wrap gap-3 mt-2">
                        <a href="#" class="text-secondary text-decoration-none small">Remove</a>
                        <a href="#" class="text-secondary text-decoration-none small">Save for Later</a>
                    </div>
                </div>
                
                <div class="text-end ms-md-4 mt-3 mt-md-0 align-self-center">
                    <div class="fs-4 fw-bold mb-1">Rp109,000</div>
                    <div class="text-decoration-line-through text-secondary mb-1">Rp149,000</div>
                    <span class="badge bg-success-subtle text-success border border-success">27% off</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-3 shadow-sm p-4">
            <div class="d-flex justify-content-between py-2 border-bottom">
                <span class="fw-medium">Total:</span>
                <span class="fs-3 fw-bold">Rp109,000</span>
            </div>
            
            <button class="btn btn-dark w-100 py-3 mt-3 fw-medium fs-5">
                Proceed to Checkout →
            </button>
            <p class="text-center text-secondary small mt-2 mb-0">You won't be charged yet</p>
        </div>
    </div>
    
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>