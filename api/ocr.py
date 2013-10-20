#!/usr/bin/env python

import numpy as np
import skimage.morphology as morphology
import cv2
import cv2.cv as cv

def do_ocr(im0):
  pass

if __name__ == "__main__":
  im = cv2.imread('img/test.png')
  if im == None:
    import sys
    sys.exit()
  do_ocr(im)

  im1 = cv2.cvtColor(im0, cv2.COLOR_BGR2GRAY)
  im2 = cv2.adaptiveThreshold(im1, 255, cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY_INV, 45, 0)
  im3 = morphology.skeletonize(im2 > 0) * 255
  im4 = cv2.copyMakeBorder(im3, 1, 1, 1, 1, cv2.BORDER_CONSTANT, value=0)
cv2.floodFill(im4, None, (0,0), 255)
im5 = cv2.erode(255-im4, np.ones((3,3), np.uint8), iterations=2)
cnt = cv2.findContours(im5, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)[0]
cnt = [c for c in cnt if cv2.contourArea(c) > 5000]
mask = np.zeros(im0.shape[:2], np.uint8)
cv2.drawContours(mask, cnt, -1, 255, -1)
dst = im2 & mask
cnt = cv2.findContours(dst.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
cnt = [c for c in cnt if cv2.contourArea(c) < 100]
cv2.drawContours(dst, cnt, -1, 0, -1)
cnt = cv2.findContours(dst.copy(), cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_NONE)
cnt = [c for c in cnt if cv2.contourArea(c) < 100]
cv2.drawContours(dst, cnt, -1, 0, -1)
api = tesseract.TessBaseAPI()
api.Init(".", "eng", tesseract.OEM_DEFAULT)
api.SetVariable("tessedit_char_whitelist", "#ABCDEFGHIJKLMNOPQRSTUVWXYZ")
api.SetPageSegMode(tesseract.PSM_SINGLE_LINE)

image = cv.CreateImageHeader(dst.shape[:2], cv.IPL_DEPTH_8U, 1)
cv.SetData(image, dst.tostring(), dst.dtype.itemsize * dst.shape[1])
tesseract.SetCvImage(image, api)
print api.GetUTF8Text().string()