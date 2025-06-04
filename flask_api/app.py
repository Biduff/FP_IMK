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
        cls_id = int(box.cls[0])
        confidence = float(box.conf[0])
        output.append({
            'class': labels[cls_id],
            'confidence': round(confidence, 3)
        })

    return jsonify(output)

if __name__ == '__main__':
    app.run(debug=True)
