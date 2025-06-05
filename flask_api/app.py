from flask import Flask, request, jsonify
from ultralytics import YOLO
from PIL import Image
import io

app = Flask(__name__)

model = YOLO('best.pt')

@app.route('/predict', methods=['POST'])
def predict():
    if 'image' not in request.files:
        return jsonify({'error': 'No image uploaded'}), 400

    file = request.files['image']
    img = Image.open(file.stream)

    results = model(img)

    labels = results[0].names
    boxes = results[0].boxes

    output = []

    for box in boxes:

        xyxy = box.xyxy[0].tolist()
        
        x1, y1, x2, y2 = xyxy
        width = x2 - x1
        height = y2 - y1
        
        box_coords = [x1, y1, width, height]
        
        cls_id = int(box.cls[0])
        confidence = float(box.conf[0])

        output.append({
            'class': labels[cls_id],
            'confidence': round(confidence, 3),
            'box': [round(c) for c in box_coords] 
        })

    return jsonify(output)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)