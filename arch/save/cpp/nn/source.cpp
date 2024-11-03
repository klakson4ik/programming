#include <iostream>
#include <vector>
#include <cmath>

using namespace std;

float sigmoid(const float value){
  return (1 / (1 + pow(2.71828, -value)));
}

int main(){
  
  const unsigned short int COUNT_INPUT_NEURONS = 6;
  const unsigned short int COUNT_HIDDEN_LAYERS = 1;
  const unsigned short int COUNT_OUTPUT_NEURONS = 1;
  float inputNeurons[COUNT_INPUT_NEURONS] = {1, 1, 0, 0, 1, 0};

  float neuronsInLayers[COUNT_HIDDEN_LAYERS + 2];
  neuronsInLayers[0] = COUNT_INPUT_NEURONS;
  unsigned short int nl[COUNT_HIDDEN_LAYERS + 2];
  nl[0] = COUNT_INPUT_NEURONS;

  float delimetr = (100 - ((float)COUNT_OUTPUT_NEURONS * 100 / COUNT_INPUT_NEURONS)) / (COUNT_HIDDEN_LAYERS + 1) * COUNT_INPUT_NEURONS / 100;   
  for(int i=0; i < COUNT_HIDDEN_LAYERS; ++i){
    neuronsInLayers[i+1] = neuronsInLayers[i] - delimetr;
  }
  for(int i=0; i < sizeof(nl)/sizeof(short int) - 1; ++i){
    nl[i] = neuronsInLayers[i]; 
  }
  nl[sizeof(nl)/sizeof(short int) - 1] = COUNT_OUTPUT_NEURONS;

  float **weights;
  weights = new float* [sizeof(nl)/sizeof(short int)];
  float **neurons = new float* [sizeof(nl)/sizeof(short int)];

  neurons[0] = new float[6];
  for(int i=0; i < COUNT_INPUT_NEURONS -1 ; ++i){
    neurons[0][i] = inputNeurons[i];
  }

  for (int i =0 ; i < sizeof(nl)/sizeof(short int) - 1; ++i) {
     weights[i] = new float [nl[i]*nl[i+1]];
     neurons[i] = new float [nl[i+1]];
      float xavier = 2 / (float)(nl[i] + nl[i+1]);
      float value = 0;
      int count = 0;
     for(int j=0; j < nl[i] * nl[i+1] ; ++j){
       if((i+1) % nl[i] == 0){
          neurons[i+1][count++] = sigmoid(value);
          value = 0;
       }else{
        weights[i][j] = xavier;
        value += neurons[i][j] *weights[i][j];
      }
     }
  }


  for (int i=0; i < sizeof(nl)/sizeof(short int); ++i){
    
  }

  for (int i =0 ; i < sizeof(nl)/sizeof(short int) - 1; ++i) {
     for(int j=0; j < nl[i+1]; ++j){
       cout <<neurons[i][j] << " ";
     }
    cout<<endl;
  }

  delete[] neurons;
  delete[] weights;
  return 0;
}
